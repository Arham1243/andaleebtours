<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Config;
use App\Models\Province;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class HotelController extends Controller
{
    protected $hotelCommissionPercentage;
    public function __construct()
    {
        $config = Config::pluck('config_value', 'config_key')->toArray();
        $this->hotelCommissionPercentage = $config['HOTEL_COMMISSION_PERCENTAGE'] ?? 10;
    }

    public function index()
    {
        $banner = Banner::where('page', 'hotels-listing')->where('status', 'active')->first();
        return view('frontend.hotels.index', compact('banner'));
    }

    public function searchHotels(Request $request)
    {
        $q = $request->input('q');

        $hotels = Hotel::with(['country', 'province', 'location'])
            ->where('name', 'like', "%{$q}%")
            ->get()
            ->map(function ($hotel) {
                return [
                    'name' => $hotel->name,
                    'country_name' => $hotel->country?->name,
                    'province_name' => $hotel->province?->name,
                    'location_name' => $hotel->location?->name,
                ];
            });

        return response()->json($hotels);
    }

    public function search(Request $request)
    {
        // 1. Build rooms array
        $rooms = $this->buildRoomsArray($request);

        // 2. Resolve destination to hotel IDs
        $hotelIds = $this->resolveDestinationToHotelIds($request->destination);

        $hotels = collect();

        if ($hotelIds->isNotEmpty()) {
            // 3. Fetch availability from API
            $hotels = $this->fetchAvailability($hotelIds, $rooms, $request);

            // 4. Apply filters
            $hotels = $this->applyFilters($hotels, $request);

            // 5. Apply sorting
            $hotels = $this->applySorting($hotels, $request);

            $hotels = $this->formatHotels($hotels);
        }
        return view('frontend.hotels.search', [
            'hotels' => $hotels->values()
        ]);
    }

    protected function buildRoomsArray(Request $request)
    {
        $rooms = [];
        for ($i = 1; $i <= $request->room_count; $i++) {
            $adults = (int) $request->input("room_{$i}_adults", 0);
            $childrenCount = (int) $request->input("room_{$i}_children", 0);
            $childAges = [];
            for ($c = 1; $c <= $childrenCount; $c++) {
                $age = $request->input("room_{$i}_child_age_{$c}");
                if ($age !== null) $childAges[] = (int) $age;
            }
            $rooms[] = ['Adults' => $adults, 'ChildAges' => $childAges];
        }
        return $rooms;
    }

    // 3. Resolve Destination to Hotel IDs
    protected function resolveDestinationToHotelIds($destination)
    {
        $hotelIds = collect();

        $country = Country::where('name', $destination)->where('status', 'active')->first();
        $province = Province::where('name', $destination)->where('status', 'active')->first();
        $location = Location::where('name', $destination)->where('status', 'active')->first();

        if ($country) {
            $provinceIds = $country->provinces()->pluck('id');
            $locationIds = Location::whereIn('province_id', $provinceIds)->pluck('id');
            $hotelIds = Hotel::whereIn('location_id', $locationIds)->pluck('yalago_id');
        } elseif ($province) {
            $locationIds = $province->locations()->pluck('id');
            $hotelIds = Hotel::whereIn('location_id', $locationIds)->pluck('yalago_id');
        } elseif ($location) {
            $hotelIds = Hotel::where('location_id', $location->id)->pluck('yalago_id');
        } else {
            $hotel = Hotel::where('name', $destination)->where('status', 'active')->first();
            if ($hotel) $hotelIds = collect([$hotel->yalago_id]);
        }

        return $hotelIds;
    }

    // 4. Fetch availability from API
    protected function fetchAvailability($hotelIds, $rooms, Request $request)
    {
        $startDate = Carbon::parse($request->check_in)->format('Y-m-d');
        $endDate = Carbon::parse($request->check_out)->format('Y-m-d');

        $payload = [
            "CheckInDate" => $startDate,
            "CheckOutDate" => $endDate,
            "EstablishmentIds" => $hotelIds->toArray(),
            "Rooms" => $rooms,
            "Culture" => "en-GB",
            "GetPackagePrice" => false,
            "GetTaxBreakdown" => true,
            "IsPackage" => false,
            "GetLocalCharges" => true,
            "CurrencyCode" => 'AED'
        ];

        $response = Http::withHeaders([
            'x-api-key' => '93082895-c45f-489f-ae10-bed9eaae161e',
            'Accept' => 'application/json'
        ])->post('https://api.yalago.com/hotels/availability/get', $payload);

        return collect($response->json()['Establishments'] ?? []);
    }

    // 5. Apply all filters
    protected function applyFilters($hotels, Request $request)
    {
        // Price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $min = $request->min_price;
            $max = $request->max_price;
            $hotels = $hotels->filter(function ($hotel) use ($min, $max) {
                foreach ($hotel['Rooms'] as $room) {
                    foreach ($room['Boards'] as $board) {
                        $price = $board['IsBindingPrice'] ? $board['GrossCost']['Amount'] : $board['NetCost']['Amount'];
                        if ((!$min || $price >= $min) && (!$max || $price <= $max)) return true;
                    }
                }
                return false;
            });
        }

        // Rating exact
        if ($request->filled('rating')) {
            $ratings = explode(',', $request->rating);
            $hotels = $hotels->filter(fn($hotel) => in_array($hotel['EstablishmentInfo']['Rating'], $ratings));
        }

        // Rating range
        $rMin = $request->input('rating_range_min');
        $rMax = $request->input('rating_range_max');
        if ($rMin || $rMax) {
            $hotels = $hotels->filter(
                fn($hotel) => (!$rMin || $hotel['EstablishmentInfo']['Rating'] >= $rMin) &&
                    (!$rMax || $hotel['EstablishmentInfo']['Rating'] <= $rMax)
            );
        }

        // Property type
        if ($request->filled('property_type')) {
            $types = explode(',', $request->property_type);
            $hotels = $hotels->filter(fn($hotel) => in_array($hotel['EstablishmentInfo']['AccomodationType'], $types));
        }

        // Hotel name
        if ($request->filled('hotel_name')) {
            $name = $request->hotel_name;
            $hotels = $hotels->filter(
                fn($hotel) =>
                stripos($hotel['EstablishmentInfo']['EstablishmentName'], $name) !== false
            );
        }

        // Board type
        if ($request->filled('board_type')) {
            $boards = explode(',', $request->board_type);
            $hotels = $hotels->filter(function ($hotel) use ($boards) {
                foreach ($hotel['Rooms'] as $room) {
                    foreach ($room['Boards'] as $board) {
                        if (in_array($board['Description'], $boards)) return true;
                    }
                }
                return false;
            });
        }

        return $hotels;
    }

    // 6. Apply sorting
    protected function applySorting($hotels, Request $request)
    {
        $sort = $request->sort_by;
        if (!$sort) return $hotels;

        if ($sort === 'price_low_to_high') {
            $hotels = $hotels->sortBy(
                fn($hotel) =>
                $hotel['Rooms'][0]['Boards'][0]['IsBindingPrice']
                    ? $hotel['Rooms'][0]['Boards'][0]['GrossCost']['Amount']
                    : $hotel['Rooms'][0]['Boards'][0]['NetCost']['Amount']
            );
        } elseif ($sort === 'price_high_to_low') {
            $hotels = $hotels->sortByDesc(
                fn($hotel) =>
                $hotel['Rooms'][0]['Boards'][0]['IsBindingPrice']
                    ? $hotel['Rooms'][0]['Boards'][0]['GrossCost']['Amount']
                    : $hotel['Rooms'][0]['Boards'][0]['NetCost']['Amount']
            );
        } elseif ($sort === 'recommended') {
            $hotels = $hotels->filter(fn($hotel) => $hotel['EstablishmentInfo']['Rating'] == 5);
        } elseif ($sort === 'top_rated') {
            $hotels = $hotels->filter(fn($hotel) => in_array($hotel['EstablishmentInfo']['Rating'], [5, 4]));
        }

        return $hotels;
    }

    private function formatHotels(Collection $hotels): Collection
    {
        $yalagoIds = $hotels->pluck('EstablishmentId')->all();

        $localHotels = Hotel::with(['province', 'location'])
            ->whereIn('yalago_id', $yalagoIds)
            ->get()
            ->keyBy('yalago_id');

        return $hotels->map(function ($item) use ($localHotels) {

            $localHotel = $localHotels->get($item['EstablishmentId']);

            $boards = collect($item['Rooms'])
                ->flatMap(fn($room) => $room['Boards']);


            $cheapestBoard = $boards
                ->sortBy('NetCost.Amount')
                ->first();

            return [
                'id' => $localHotel?->id,

                'name' => $localHotel?->name,
                'address' => $localHotel?->address,
                'rating' => $localHotel?->rating,
                'rating_text' => $localHotel?->rating_text,

                'province' => $localHotel?->province?->name,
                'location' => $localHotel?->location?->name,

                'image' => data_get($localHotel?->images, '0.Url'),

                'price' => calculatePriceWithCommission(data_get($cheapestBoard, 'NetCost.Amount'), $this->hotelCommissionPercentage),

                'boards' => $boards
                    ->pluck('Description')
                    ->unique()
                    ->values(),
            ];
        });
    }

    private function formatHotel(Hotel $hotel, ?float $price = null, ?array $boards = null): array
    {
        return [
            'id'          => $hotel->id,
            'name'        => $hotel->name,
            'address'     => $hotel->address,
            'rating'      => $hotel->rating,
            'description'      => $hotel->description,
            'rating_text' => $hotel->rating_text,
            'province'    => $hotel->province?->name,
            'location'    => $hotel->location?->name,
            'images'      => $hotel->images,

            // API-related fields
            'price'       => $price
                ? calculatePriceWithCommission($price, $this->hotelCommissionPercentage)
                : null,
            'boards'      => collect($boards ?? [])->pluck('Description')->unique()->values(),
        ];
    }


    public function details(Request $request, int $id)
    {
        // 1. Fetch hotel with relations
        $hotel = Hotel::with(['province', 'location', 'country'])->findOrFail($id);

        // 2. Parse check-in/out dates
        $startDate = Carbon::parse($request->check_in)->format('Y-m-d');
        $endDate   = Carbon::parse($request->check_out)->format('Y-m-d');

        // 3. Build rooms array dynamically
        $rooms = $this->buildRoomsArray($request);

        // 4. Fetch availability from Yalago API
        $availabilityPayload = [
            "CheckInDate"      => $startDate,
            "CheckOutDate"     => $endDate,
            "EstablishmentIds" => [$hotel->yalago_id],
            "Rooms"            => $rooms,
            "Culture"          => "en-GB",
            "GetPackagePrice"  => false,
            "IsPackage"        => false,
            "GetTaxBreakdown"  => true,
            "GetLocalCharges"  => true,
            "IsBindingPrice"   => true,
        ];

        $availability = Http::withHeaders([
            'x-api-key' => '93082895-c45f-489f-ae10-bed9eaae161e',
            'Accept'    => 'application/json',
        ])->post('https://api.yalago.com/hotels/availability/get', $availabilityPayload)
            ->json('Establishments', []);

        $availableList = collect($availability);

        if ($availableList->isEmpty()) {
            return redirect()->route('frontend.hotels.search')
                ->with('error', 'No Hotel Found! Please try again.');
        }

        // 5. Fetch detailed hotel info for first room as default
        $firstRoom = $availableList[0]['Rooms'][0] ?? null;
        $hotelApiData = $availableList[0] ?? null;
        $boardsCollection = collect($hotelApiData['Rooms'] ?? [])
            ->flatMap(fn($room) => $room['Boards'] ?? []);

        $cheapestBoard = $boardsCollection->sortBy('NetCost.Amount')->first();


        $hotelFormatted = $this->formatHotel(
            $hotel,
            $cheapestBoard['NetCost']['Amount'] ?? null,
            $boardsCollection->all()
        );
        $roomCode  = $firstRoom['Code'] ?? null;
        $boardCode = $firstRoom['Boards'][0]['Code'] ?? null;

        if (!$roomCode || !$boardCode) {
            return redirect()->back()->with('error', 'Unable to fetch hotel details. Missing room or board codes.');
        }

        $detailPayload = [
            "CheckInDate"     => $startDate,
            "CheckOutDate"    => $endDate,
            "EstablishmentId" => $hotel->yalago_id, // single int, not array
            "Rooms"           => [
                [
                    "Adults"    => $rooms[0]['Adults'] ?? 1,
                    "ChildAges" => $rooms[0]['ChildAges'] ?? [],
                    "RoomCode"  => $roomCode,
                    "BoardCode" => $boardCode,
                ]
            ],
            "Culture"         => "en-GB",
            "GetPackagePrice" => false,
            "GetTaxBreakdown" => true,
            "GetLocalCharges" => true,
            "GetBoardBasis"   => true,
            "CurrencyCode"    => "AED",
        ];

        $response = Http::withHeaders([
            'x-api-key' => '93082895-c45f-489f-ae10-bed9eaae161e',
            'Accept'    => 'application/json',
        ])->post('https://api.yalago.com/hotels/details/get', $detailPayload)
            ->json();
        // 6. Build structured data for view
        $data = [
            'hotel'      => $hotelFormatted,
            'info_items' => $response['InfoItems'] ?? [],
            'api_availability' => $availableList,
            'total_rooms'      => count($rooms),
            'show_extras'      => $hotel->country?->iso_code === 'ML',
            'check_in'         => $startDate,
            'check_out'        => $endDate,
            'rooms_request'    => $rooms,
        ];
        return view('frontend.hotels.details', $data);
    }

    public function checkout()
    {
        $is_extras = false;
        $data = compact('is_extras');
        return view('frontend.hotels.checkout')->with($data);
    }

    public function extras()
    {
        $is_extras = true;
        $data = compact('is_extras');
        return view('frontend.hotels.checkout')->with($data);
    }
}

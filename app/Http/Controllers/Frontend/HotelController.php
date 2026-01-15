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
use Illuminate\Support\Facades\Log;
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

        if (!$request->has(['destination', 'check_in', 'check_out', 'room_count'])) {
            return redirect()->route('frontend.hotels.index')
                ->with('notify_error', 'Missing required parameters.');
        }


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
            "SourceMarket" => "",
            "Culture" => "en-GB",
            "GetPackagePrice" => false,
            "GetTaxBreakdown" => true,
            "IsPackage" => false,
            "GetLocalCharges" => true,
            "IsBindingPrice" => true
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

            // decode images if they are JSON string
            $images = is_string($localHotel->images)
                ? json_decode($localHotel->images, true)
                : $localHotel->images;

            return [
                'id' => $localHotel?->id,

                'name' => $localHotel?->name,
                'address' => $localHotel?->address,
                'rating' => $localHotel?->rating,
                'rating_text' => $localHotel?->rating_text,

                'province' => $localHotel?->province?->name,
                'location' => $localHotel?->location?->name,

                'image'    => $images[0]['Url'] ?? null,

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
        // decode images if they are JSON string
        $images = is_string($hotel->images)
            ? json_decode($hotel->images, true)
            : $hotel->images;

        return [
            'id'          => $hotel->id,
            'yalago_id'   => $hotel->yalago_id,
            'name'        => $hotel->name,
            'address'     => $hotel->address,
            'rating'      => $hotel->rating,
            'description'      => $hotel->description,
            'rating_text' => $hotel->rating_text,
            'province'    => $hotel->province?->name,
            'location'    => $hotel->location?->name,
            'images'      => $images,
            'image'    => $images[0]['Url'] ?? null,

            // API-related fields
            'price'       => $price
                ? calculatePriceWithCommission($price, $this->hotelCommissionPercentage)
                : null,
            'boards'      => collect($boards ?? [])->pluck('Description')->unique()->values(),
        ];
    }


    public function details(Request $request, int $id)
    {
        if (!$request->has(['check_in', 'check_out', 'room_count'])) {
            return redirect()->route('frontend.hotels.index')
                ->with('notify_error', 'Missing required parameters.');
        }

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
                ->with('notify_error', 'No Hotel Found! Please try again.');
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
            return redirect()->back()->with('notify_error', 'Unable to fetch hotel details. Missing room or board codes.');
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
            'show_extras'      => $hotel->country?->iso_code === 'MV',
            'check_in'         => $startDate,
            'check_out'        => $endDate,
            'rooms_request'    => $rooms,
            'hotelCommissionPercentage'    => $this->hotelCommissionPercentage,
        ];
        return view('frontend.hotels.details', $data);
    }



    public function checkout(Request $request, int $id)
    {
        // Required query parameters
        $requiredParams = [
            'check_in',
            'check_out',
            'room_count',
            'room_code',
            'board_code',
            'price',
            'room_name',
            'show_extras'
        ];

        foreach ($requiredParams as $param) {
            if (!$request->has($param)) {
                return redirect()->route('frontend.hotels.index')
                    ->with('notify_error', 'Missing required information. Please try again.');
            }
        }

        // 1. Fetch hotel
        $hotel = Hotel::with(['province', 'location', 'country'])->findOrFail($id);

        // 2. Parse dates from query
        $startDate = Carbon::parse($request->query('check_in'))->format('Y-m-d');
        $endDate   = Carbon::parse($request->query('check_out'))->format('Y-m-d');

        // 3. Build rooms array from query parameters
        $rooms = $this->buildRoomsArray($request);

        // 4. Get selected room_code, board_code, price, room_name from query
        $roomCode  = $request->query('room_code');
        $boardCode = $request->query('board_code');
        $boardTitle = $request->query('board_title');
        $price     = (float) $request->query('price');
        $roomName  = $request->query('room_name');
        $showExtras = filter_var($request->query('show_extras', false), FILTER_VALIDATE_BOOLEAN);

        // 5. Fetch availability from Yalago API (like legacy code)
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

        if (empty($availability)) {
            return redirect()->route('frontend.hotels.search')
                ->with('notify_error', 'No availability found for this hotel. Please try again.');
        }

        $availableList = collect($availability);

        // 6. Fetch detailed info for the selected room
        $detailPayload = [
            "CheckInDate"     => $startDate,
            "CheckOutDate"    => $endDate,
            "EstablishmentId" => $hotel->yalago_id,
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

        // 7. Format hotel info and boards
        $boardsCollection = collect($availableList[0]['Rooms'] ?? [])
            ->flatMap(fn($room) => $room['Boards'] ?? []);

        $cheapestBoard = $boardsCollection->sortBy('NetCost.Amount')->first();

        $hotelFormatted = $this->formatHotel(
            $hotel,
            $cheapestBoard['NetCost']['Amount'] ?? null,
            $boardsCollection->all()
        );

        $extras = collect($response['Establishment']['Rooms'] ?? [])
            ->flatMap(
                fn($room) =>
                collect($room['Boards'] ?? [])
                    ->flatMap(
                        fn($board) =>
                        collect($board['Extras'] ?? [])
                            ->map(fn($extra) => [
                                'room'  => $room,
                                'board' => $board,
                                'extra' => $extra,
                            ])
                    )
            )
            ->values();
        // 8. Prepare data for checkout view
        $data = [
            'hotel'            => $hotelFormatted,
            'api_availability' => $availableList,
            'selected_room'    => [
                'room_code'  => $roomCode,
                'board_code' => $boardCode,
                'board_title' => $boardTitle,
                'price'      => $price,
                'room_name'  => $roomName,
            ],
            'rooms_request'    => $rooms,
            'show_extras'    => $showExtras,
            'yalago_extras' => $extras,
            'total_rooms'      => count($rooms),
            'info_items'       => $response['InfoItems'] ?? [],
            'check_in'         => $startDate,
            'check_out'        => $endDate,
            'hotelCommissionPercentage' => $this->hotelCommissionPercentage,
        ];

        return view('frontend.hotels.checkout', $data);
    }


    public function processPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'hotel_id' => 'required|integer',
                'check_in' => 'required|date',
                'check_out' => 'required|date|after:check_in',
                'rooms' => 'required|array',
                'selected_room.room_code' => 'required|string',
                'selected_room.board_code' => 'required|string',
                'selected_room.board_title' => 'required|string',
                'selected_room.price' => 'required|numeric',
                'selected_room.room_name' => 'required|string',
                'booking.lead_guest.title' => 'required|string',
                'booking.lead_guest.first_name' => 'required|string',
                'booking.lead_guest.last_name' => 'required|string',
                'booking.lead_guest.email' => 'required|email',
                'booking.lead_guest.phone' => 'required|string',
                'booking.lead_guest.address' => 'required|string',
                'booking.guests' => 'nullable|array',
                'booking.extras' => 'nullable|array',
                'flight_details' => 'nullable|array',
                'payment_method' => 'required|in:payby,tabby',
            ]);

            // Get hotel information from POST data
            $hotelId = $validated['hotel_id'];
            $hotel = Hotel::where('yalago_id', $hotelId)->first();

            if (!$hotel) {
                return redirect()->route('frontend.hotels.index')
                    ->with('notify_error', 'Hotel not found.');
            }

            // Build rooms data from POST data
            $roomsData = [];
            foreach ($validated['rooms'] as $room) {
                $childAges = [];
                if (!empty($room['child_ages'])) {
                    $childAges = array_map('intval', explode(',', $room['child_ages']));
                }
                $roomsData[] = [
                    'Adults' => (int)$room['adults'],
                    'ChildAges' => $childAges
                ];
            }

            // Calculate extras total
            $extrasTotal = 0;
            $extrasData = [];
            if (isset($validated['booking']['extras'])) {
                foreach ($validated['booking']['extras'] as $extra) {
                    $extrasTotal += (float)($extra['price'] ?? 0);
                    $extrasData[] = [
                        'title' => $extra['title'] ?? '',
                        'price' => (float)($extra['price'] ?? 0),
                        'option_id' => $extra['option_id'] ?? '',
                        'extra_id' => $extra['extra_id'] ?? '',
                        'extra_type_id' => $extra['extra_type_id'] ?? '',
                    ];
                }
            }

            // Calculate total amount
            $roomsTotal = (float)$validated['selected_room']['price'];
            $totalAmount = $roomsTotal + $extrasTotal;

            // Get source market from IP
            $sourceMarket = $this->getSourceMarketFromIP();

            // Prepare booking data
            $bookingData = [
                'yalago_hotel_id' => $hotel->yalago_id,
                'hotel_name' => $hotel->name,
                'hotel_address' => $hotel->address,
                'check_in_date' => $validated['check_in'],
                'check_out_date' => $validated['check_out'],
                'rooms_data' => $roomsData,
                'selected_rooms' => [$validated['selected_room']],
                'lead_guest' => $validated['booking']['lead_guest'],
                'guests' => $validated['booking']['guests'] ?? null,
                'extras' => $extrasData,
                'extras_total' => $extrasTotal,
                'flight_details' => $validated['flight_details'] ?? null,
                'rooms_total' => $roomsTotal,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'source_market' => $sourceMarket,
            ];

            // Initialize HotelService
            $hotelService = new \App\Services\HotelService();

            // Create booking record
            $booking = $hotelService->createBookingRecord($bookingData);

            // Verify availability
            $availabilityCheck = $hotelService->verifyAvailability($booking);

            if (!$availabilityCheck['success']) {
                $booking->update([
                    'booking_status' => 'failed',
                    'payment_status' => 'failed',
                ]);

                return redirect()->route('frontend.hotels.index')
                    ->with('notify_error', $availabilityCheck['error']);
            }

            // Get payment redirect URL
            try {
                $redirectUrl = $hotelService->getRedirectUrl($booking, $validated['payment_method']);
                return redirect($redirectUrl);
            } catch (\Exception $e) {
                $booking->update([
                    'booking_status' => 'failed',
                    'payment_status' => 'failed',
                ]);

                Log::error('Payment redirect failed', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage()
                ]);

                return redirect()->route('frontend.hotels.payment.failed', ['booking' => $booking->id])
                    ->with('notify_error', 'Unable to process payment. Please try again.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('notify_error', 'Please fill in all required fields correctly.');
        } catch (\Exception $e) {
            Log::error('Hotel booking process failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('frontend.hotels.index')
                ->with('notify_error', 'An error occurred while processing your booking. Please try again.');
        }
    }

    public function paymentSuccess(Request $request, $booking)
    {
        try {
            $booking = \App\Models\HotelBooking::findOrFail($booking);

            // Prevent re-processing if already paid
            if ($booking->isPaid() && $booking->isConfirmed()) {
                return redirect()->route('frontend.hotels.payment.success.view', ['booking' => $booking->id]);
            }

            $hotelService = new \App\Services\HotelService();

            // Verify payment based on payment method
            if ($booking->payment_method === 'payby') {
                $verificationResult = $hotelService->verifyPayByPayment($booking);
            } elseif ($booking->payment_method === 'tabby') {
                $verificationResult = $hotelService->verifyTabbyPayment($booking);
            } else {
                throw new \Exception('Invalid payment method');
            }

            if (!$verificationResult['success']) {
                $booking->update([
                    'payment_status' => 'failed',
                    'booking_status' => 'failed',
                ]);

                $hotelService->sendBookingFailureEmail($booking, $verificationResult['error'] ?? 'Payment verification failed');
                $hotelService->sendBookingFailureEmailToAdmin($booking, $verificationResult['error'] ?? 'Payment verification failed');

                return redirect()->route('frontend.hotels.payment.failed', ['booking' => $booking->id])
                    ->with('notify_error', 'Payment verification failed. Please contact support.');
            }

            // Update payment status
            $booking->update([
                'payment_status' => 'paid',
                'payment_response' => $verificationResult['data'] ?? null,
            ]);

            // Place booking order with Yalago
            $bookingResult = $hotelService->placeBookingOrder($booking);

            if (!$bookingResult['success']) {
                $hotelService->sendBookingFailureEmail($booking, $bookingResult['error'] ?? 'Booking placement failed');
                $hotelService->sendBookingFailureEmailToAdmin($booking, $bookingResult['error'] ?? 'Booking placement failed');

                return redirect()->route('frontend.hotels.payment.failed', ['booking' => $booking->id])
                    ->with('notify_error', 'Unable to confirm your booking. Our team will contact you shortly.');
            }

            // Send confirmation emails
            $hotelService->sendBookingConfirmationEmail($booking);
            $hotelService->sendBookingConfirmationEmailToAdmin($booking);

            return redirect()->route('frontend.hotels.payment.success.view', ['booking' => $booking->id]);
        } catch (\Exception $e) {
            Log::error('Payment success processing failed', [
                'booking_id' => $booking ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('frontend.hotels.index')
                ->with('notify_error', 'An error occurred while processing your payment. Please contact support.');
        }
    }

    public function paymentSuccessView($booking)
    {
        try {
            $booking = \App\Models\HotelBooking::findOrFail($booking);

            if (!$booking->isPaid()) {
                return redirect()->route('frontend.hotels.index')
                    ->with('notify_error', 'Invalid booking access.');
            }

            return view('frontend.hotels.payment-success', compact('booking'));
        } catch (\Exception $e) {
            return redirect()->route('frontend.hotels.index')
                ->with('notify_error', 'Booking not found.');
        }
    }

    public function paymentFailed(Request $request, $booking = null)
    {
        try {
            if ($booking) {
                $booking = \App\Models\HotelBooking::findOrFail($booking);

                if ($booking->payment_status === 'pending') {
                    $booking->update([
                        'payment_status' => 'failed',
                        'booking_status' => 'failed',
                    ]);

                    $hotelService = new \App\Services\HotelService();
                    $hotelService->sendBookingFailureEmail($booking, 'Payment was cancelled or failed');
                    $hotelService->sendBookingFailureEmailToAdmin($booking, 'Payment was cancelled or failed');
                }

                return view('frontend.hotels.payment-failed', compact('booking'));
            }

            return view('frontend.hotels.payment-failed', ['booking' => null]);
        } catch (\Exception $e) {
            return view('frontend.hotels.payment-failed', ['booking' => null]);
        }
    }

    protected function getSourceMarketFromIP()
    {
        try {
            $ip = request()->ip();
            $response = file_get_contents("https://ipinfo.io/{$ip}/json");
            $data = json_decode($response, true);

            if (isset($data['country'])) {
                return $data['country'];
            }
        } catch (\Exception $e) {
            Log::warning('Failed to get source market from IP', ['error' => $e->getMessage()]);
        }

        return 'AE';
    }
}

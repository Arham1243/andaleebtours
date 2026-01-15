<?php

namespace App\Services;

use App\Models\HotelBooking;
use App\Models\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;
use DateTime;

class HotelService
{
    public $commissionPercentage;

    public $tabbyApiKey = 'pk_03168c56-d196-4e58-a72a-48dbebb88b87';
    public $tabbyMerchantCode = 'ATA';
    public $tabbyApiUrl = 'https://api.tabby.ai/api/v2';

    public $paybyPartnerId = '200009116289';
    public $paybyApiUrl = 'https://api.payby.com/sgs/api/acquire2';
    public $paybyPrivateKey = 'admin/assets/files/payby-private-key.pem';

    // Yalago API Configuration
    private $yalagoApiKey = '93082895-c45f-489f-ae10-bed9eaae161e';
    private $yalagoApiUrl = 'https://api.yalago.com/hotels';
    protected $adminEmail;


    public function __construct()
    {
        $config = Config::pluck('config_value', 'config_key')->toArray();
        $this->commissionPercentage = ($config['HOTEL_COMMISSION_PERCENTAGE'] ?? 30) / 100;
        $this->adminEmail = $config['ADMINEMAIL'] ?? 'info@andaleebtours.com';
    }


    /**
     * Create hotel booking record
     */
    public function createBookingRecord(array $data): HotelBooking
    {
        $checkIn = new DateTime($data['check_in_date']);
        $checkOut = new DateTime($data['check_out_date']);
        $nights = $checkIn->diff($checkOut)->days;

        $bookingData = [
            'user_id' => auth()->id() ?? null,
            'booking_number' => HotelBooking::generateBookingNumber(),
            'yalago_hotel_id' => $data['yalago_hotel_id'],
            'hotel_name' => $data['hotel_name'],
            'hotel_address' => $data['hotel_address'] ?? null,
            'check_in_date' => $data['check_in_date'],
            'check_out_date' => $data['check_out_date'],
            'nights' => $nights,
            'rooms_data' => $data['rooms_data'],
            'selected_rooms' => $data['selected_rooms'],
            'lead_title' => $data['lead_guest']['title'] ?? null,
            'lead_first_name' => $data['lead_guest']['first_name'],
            'lead_last_name' => $data['lead_guest']['last_name'],
            'lead_email' => $data['lead_guest']['email'],
            'lead_phone' => $data['lead_guest']['phone'],
            'lead_address' => $data['lead_guest']['address'] ?? null,
            'guests_data' => $data['guests'] ?? null,
            'extras_data' => $data['extras'] ?? null,
            'extras_total' => $data['extras_total'] ?? 0,
            'flight_details' => $data['flight_details'] ?? null,
            'rooms_total' => $data['rooms_total'],
            'total_amount' => $data['total_amount'],
            'currency' => 'AED',
            'payment_method' => $data['payment_method'],
            'payment_status' => 'pending',
            'booking_status' => 'pending',
            'source_market' => $data['source_market'] ?? 'AE',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        $booking = HotelBooking::create($bookingData);

        return $booking;
    }

    /**
     * Verify hotel availability before payment
     */
    public function verifyAvailability(HotelBooking $booking): array
    {
        try {
            $roomsData = $booking->rooms_data;
            $selectedRooms = $booking->selected_rooms;

            $requestData = [
                'CheckInDate' => $booking->check_in_date->format('Y-m-d'),
                'CheckOutDate' => $booking->check_out_date->format('Y-m-d'),
                'EstablishmentIds' => [$booking->yalago_hotel_id],
                'Rooms' => $roomsData,
                'Culture' => 'en-gb',
                'IsBindingPrice' => true,
                'GetPackagePrice' => false,
                'IsPackage' => false,
                'GetTaxBreakdown' => true,
                'GetLocalCharges' => true,
            ];

            $response = Http::withHeaders([
                'x-api-key' => $this->yalagoApiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->yalagoApiUrl . '/availability/get', $requestData);

            if (!$response->successful()) {
                throw new Exception('Yalago availability API request failed: ' . $response->body());
            }

            $responseData = $response->json();

            // Store availability request/response
            $booking->update([
                'availability_request' => $requestData,
                'availability_response' => $responseData,
            ]);

            // Check if the selected rooms are still available
            if (empty($responseData['Establishments'])) {
                return [
                    'success' => false,
                    'error' => 'Hotel is no longer available for the selected dates.'
                ];
            }

            $establishment = $responseData['Establishments'][0];
            $availableRooms = $establishment['Rooms'] ?? [];

            // Validate each selected room is still available
            foreach ($selectedRooms as $selectedRoom) {
                $roomFound = false;
                foreach ($availableRooms as $room) {
                    if ($room['Code'] === $selectedRoom['room_code']) {
                        foreach ($room['Boards'] as $board) {
                            if ($board['Code'] === $selectedRoom['board_code']) {
                                $roomFound = true;
                                break;
                            }
                        }
                    }
                }

                if (!$roomFound) {
                    return [
                        'success' => false,
                        'error' => 'Selected room is no longer available. Please search again.'
                    ];
                }
            }

            return [
                'success' => true,
                'data' => $responseData
            ];
        } catch (Exception $e) {
            Log::error('Hotel Availability Verification Error', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Unable to verify hotel availability. Please try again.'
            ];
        }
    }

    /**
     * Get redirect URL based on payment method
     */
    public function getRedirectUrl(HotelBooking $booking, string $paymentMethod): string
    {
        switch ($paymentMethod) {
            case 'payby':
                return $this->paybyRedirect($booking);

            case 'tabby':
                return $this->tabbyRedirect($booking);

            default:
                throw new \InvalidArgumentException("Unsupported payment method: {$paymentMethod}");
        }
    }

    /**
     * PayBy Redirect
     */
    protected function paybyRedirect(HotelBooking $booking)
    {
        $requestTime = now()->timestamp * 1000;
        $finalAmount = $booking->total_amount;

        $requestData = [
            'requestTime' => $requestTime,
            'bizContent' => [
                'merchantOrderNo' => $booking->booking_number,
                'subject' => 'HOTEL BOOKING',
                'totalAmount' => [
                    'currency' => 'AED',
                    'amount' => number_format((float)$finalAmount, 2, '.', '')
                ],
                'paySceneCode' => 'PAYPAGE',
                'paySceneParams' => [
                    'redirectUrl' => route('frontend.hotels.payment.success', ['booking' => $booking->id]),
                    'backUrl' => route('frontend.hotels.payment.failed', ['booking' => $booking->id])
                ],
                'reserved' => 'Andaleeb Hotel Booking',
                'accessoryContent' => [
                    'goodsDetail' => [
                        'body' => 'Hotel Booking',
                        'categoriesTree' => 'CT12',
                        'goodsCategory' => 'GC10',
                        'goodsId' => 'GI1005',
                        'goodsName' => $booking->hotel_name,
                        'price' => [
                            'currency' => 'AED',
                            'amount' => number_format((float)$finalAmount, 2, '.', '')
                        ],
                        'quantity' => 1
                    ],
                    'terminalDetail' => [
                        'operatorId' => 'OP1000000000000001',
                        'storeId' => 'SI100000000000002',
                        'terminalId' => 'TI100999999999900',
                        'merchantName' => 'ANDALEEB TRAVEL AGENCY',
                        'storeName' => 'ANDALEEB TRAVEL AGENCY'
                    ]
                ]
            ]
        ];

        $jsonPayload = json_encode($requestData);

        $privateKeyPath = public_path($this->paybyPrivateKey);
        if (!file_exists($privateKeyPath)) {
            throw new \Exception('Private key file not found at: ' . $privateKeyPath);
        }

        $privateKey = file_get_contents($privateKeyPath);
        $signature = '';
        openssl_sign($jsonPayload, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $base64Signature = base64_encode($signature);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Content-Language' => 'en',
            'Partner-Id' => $this->paybyPartnerId,
            'sign' => $base64Signature,
        ])->post($this->paybyApiUrl . '/placeOrder', $requestData);

        if (!$response->successful()) {
            throw new \Exception('PayBy API request failed: ' . $response->body());
        }

        $responseData = $response->json();

        if (
            isset($responseData['head']['applyStatus']) &&
            $responseData['head']['applyStatus'] === 'SUCCESS' &&
            isset($responseData['body']['acquireOrder']['status']) &&
            $responseData['body']['acquireOrder']['status'] === 'CREATED'
        ) {
            return $responseData['body']['interActionParams']['tokenUrl'] ?? throw new \Exception('Payment URL not found in response');
        }

        throw new \Exception('PayBy order creation failed: ' . ($responseData['head']['msg'] ?? 'Unknown error'));
    }

    /**
     * Tabby Redirect
     */
    protected function tabbyRedirect(HotelBooking $booking)
    {
        $finalAmount = $booking->total_amount + ($booking->total_amount * $this->commissionPercentage);

        $items = [[
            'title' => $booking->hotel_name,
            'description' => "Hotel Booking - {$booking->nights} nights",
            'quantity' => 1,
            'unit_price' => number_format((float)$finalAmount, 2, '.', ''),
            'category' => 'Hotel Accommodation'
        ]];

        $merchantCode = $this->tabbyMerchantCode;
        $tabbyApiKey = $this->tabbyApiKey;

        if (!$merchantCode || !$tabbyApiKey) {
            throw new \Exception('Tabby merchant code or API key is missing. Check your .env file.');
        }

        $requestData = [
            'payment' => [
                'amount' => number_format((float)$finalAmount, 2, '.', ''),
                'currency' => 'AED',
                'description' => 'Hotel Booking - Andaleeb Travel Agency',
                'buyer' => [
                    'phone' => $booking->lead_phone,
                    'email' => $booking->lead_email,
                    'name' => $booking->lead_full_name,
                    'dob' => '1990-01-01'
                ],
                'shipping_address' => [
                    'city' => 'N/A',
                    'address' => $booking->lead_address ?? 'N/A',
                    'zip' => '00000'
                ],
                'order' => [
                    'tax_amount' => '0.00',
                    'shipping_amount' => '0.00',
                    'discount_amount' => '0.00',
                    'updated_at' => now()->toIso8601String(),
                    'reference_id' => $booking->booking_number,
                    'items' => $items
                ],
                'buyer_history' => [
                    'registered_since' => now()->subYears(2)->toIso8601String(),
                    'loyalty_level' => 0,
                    'wishlist_count' => 0,
                    'is_social_networks_connected' => true,
                    'is_phone_number_verified' => true,
                    'is_email_verified' => true
                ],
                'order_history' => [
                    [
                        'purchased_at' => now()->subMonths(3)->toIso8601String(),
                        'amount' => '100.00',
                        'payment_method' => 'card',
                        'status' => 'new',
                        'buyer' => [
                            'phone' => $booking->lead_phone,
                            'email' => $booking->lead_email,
                            'name' => $booking->lead_full_name,
                            'dob' => '1990-01-01'
                        ],
                        'shipping_address' => [
                            'city' => 'Dubai',
                            'address' => $booking->lead_address ?? 'N/A',
                            'zip' => '00000'
                        ],
                        'items' => $items
                    ]
                ],
                'meta' => [
                    'order_id' => (string)$booking->id,
                    'customer' => (string)$booking->id
                ],
                'attachment' => [
                    'body' => json_encode([
                        'booking_details' => [
                            'booking_number' => $booking->booking_number,
                            'hotel_name' => $booking->hotel_name
                        ]
                    ]),
                    'content_type' => 'application/vnd.tabby.v1+json'
                ]
            ],
            'lang' => 'en',
            'merchant_code' => $merchantCode,
            'merchant_urls' => [
                'success' => route('frontend.hotels.payment.success', ['booking' => $booking->id]),
                'cancel' => route('frontend.hotels.payment.failed'),
                'failure' => route('frontend.hotels.payment.failed')
            ]
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $tabbyApiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($this->tabbyApiUrl . '/checkout', $requestData);

        if (!$response->successful()) {
            throw new \Exception('Tabby API request failed: ' . $response->body());
        }

        $responseData = $response->json();

        if (isset($responseData['configuration']['available_products']['installments'][0]['web_url'])) {
            if (isset($responseData['payment']['id'])) {
                $booking->update([
                    'tabby_payment_id' => $responseData['payment']['id']
                ]);

                Log::info('Tabby payment ID saved', [
                    'booking_id' => $booking->id,
                    'payment_id' => $responseData['payment']['id']
                ]);
            }

            return $responseData['configuration']['available_products']['installments'][0]['web_url'];
        }

        throw new \Exception('Tabby checkout creation failed: No redirect URL found in response');
    }

    /**
     * Verify PayBy Payment
     */
    public function verifyPayByPayment(HotelBooking $booking): array
    {
        try {
            $requestTime = now()->timestamp * 1000;

            $requestData = [
                'requestTime' => $requestTime,
                'bizContent' => [
                    'merchantOrderNo' => $booking->booking_number
                ]
            ];

            $jsonPayload = json_encode($requestData);
            $privateKeyPath = public_path($this->paybyPrivateKey);

            if (!file_exists($privateKeyPath)) {
                throw new \Exception('PayBy private key file not found');
            }

            $privateKey = file_get_contents($privateKeyPath);
            $signature = '';
            openssl_sign($jsonPayload, $signature, $privateKey, OPENSSL_ALGO_SHA256);
            $base64Signature = base64_encode($signature);

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Content-Language' => 'en',
                'Partner-Id' => $this->paybyPartnerId,
                'sign' => $base64Signature,
            ])->post($this->paybyApiUrl . '/getOrder', $requestData);

            if (!$response->successful()) {
                throw new \Exception('PayBy verification API request failed: ' . $response->body());
            }

            $responseData = $response->json();

            if (
                isset($responseData['body']['acquireOrder']['status']) &&
                $responseData['body']['acquireOrder']['status'] === 'SETTLED' &&
                isset($responseData['head']['applyStatus']) &&
                $responseData['head']['applyStatus'] === 'SUCCESS'
            ) {
                return [
                    'success' => true,
                    'data' => $responseData
                ];
            }

            throw new \Exception('PayBy payment not settled. Status: ' . ($responseData['body']['acquireOrder']['status'] ?? 'Unknown'));
        } catch (\Exception $e) {
            Log::error('PayBy Verification Error', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify Tabby Payment
     * 
     * TODO: Need to implement proper verification from Tabby merchant dashboard
     * Currently returning success by default for testing purposes
     */
    public function verifyTabbyPayment(HotelBooking $booking): array
    {
        // TODO: Implement actual Tabby payment verification
        // For now, return success to allow testing
        return [
            'success' => true,
            'data' => []
        ];
    }

    /**
     * Place booking order with Yalago API after successful payment
     */
    public function placeBookingOrder(HotelBooking $booking): array
    {
        try {
            $roomsData = $booking->rooms_data;
            $selectedRooms = $booking->selected_rooms;
            $extrasData = $booking->extras_data ?? [];

            // Build rooms array for booking
            $bookingRooms = [];
            foreach ($selectedRooms as $index => $selectedRoom) {
                $roomBooking = [
                    'Code' => $selectedRoom['room_code'],
                    'BoardCode' => $selectedRoom['board_code'],
                ];

                // Add extras if available
                if (!empty($extrasData)) {
                    $roomExtras = [];
                    foreach ($extrasData as $extra) {
                        $roomExtras[] = [
                            'ExtraId' => $extra['extra_id'],
                            'ExtraTypeId' => $extra['extra_type_id'],
                            'OptionId' => $extra['option_id'],
                        ];
                    }
                    if (!empty($roomExtras)) {
                        $roomBooking['Extras'] = $roomExtras;
                    }
                }

                $bookingRooms[] = $roomBooking;
            }

            // Build guests array
            $guests = [];

            // Add lead guest
            $guests[] = [
                'Title' => $booking->lead_title ?? 'Mr',
                'FirstName' => $booking->lead_first_name,
                'LastName' => $booking->lead_last_name,
                'IsLeadGuest' => true,
            ];

            // Add other guests
            if (!empty($booking->guests_data)) {
                foreach ($booking->guests_data as $guest) {
                    $guests[] = [
                        'Title' => $guest['title'] ?? 'Mr',
                        'FirstName' => $guest['first_name'],
                        'LastName' => $guest['last_name'],
                        'IsLeadGuest' => false,
                    ];
                }
            }

            $requestData = [
                'EstablishmentId' => $booking->yalago_hotel_id,
                'CheckInDate' => $booking->check_in_date->format('Y-m-d'),
                'CheckOutDate' => $booking->check_out_date->format('Y-m-d'),
                'Rooms' => $bookingRooms,
                'Guests' => $guests,
                'LeadGuest' => [
                    'Title' => $booking->lead_title ?? 'Mr',
                    'FirstName' => $booking->lead_first_name,
                    'LastName' => $booking->lead_last_name,
                    'Email' => $booking->lead_email,
                    'Phone' => $booking->lead_phone,
                    'Address' => $booking->lead_address ?? '',
                ],
                'SpecialRequests' => '',
                'InternalReference' => $booking->booking_number,
            ];

            // Add flight details if available
            if (!empty($booking->flight_details)) {
                $flightDetails = $booking->flight_details;
                if (isset($flightDetails['outbound'])) {
                    $requestData['ArrivalFlightNumber'] = $flightDetails['outbound']['flight_number'] ?? '';
                    $requestData['ArrivalTime'] = ($flightDetails['outbound']['arrival_hour'] ?? '00') . ':' . ($flightDetails['outbound']['arrival_minute'] ?? '00');
                }
                if (isset($flightDetails['inbound'])) {
                    $requestData['DepartureFlightNumber'] = $flightDetails['inbound']['flight_number'] ?? '';
                    $requestData['DepartureTime'] = ($flightDetails['inbound']['departure_hour'] ?? '00') . ':' . ($flightDetails['inbound']['departure_minute'] ?? '00');
                }
            }

            $response = Http::withHeaders([
                'x-api-key' => $this->yalagoApiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->yalagoApiUrl . '/booking/create', $requestData);

            if (!$response->successful()) {
                throw new Exception('Yalago booking API request failed: ' . $response->body());
            }

            $responseData = $response->json();

            // Store booking request/response
            $booking->update([
                'booking_request' => $requestData,
                'booking_response' => $responseData,
            ]);

            // Check if booking was successful
            if (isset($responseData['BookingReference']) && !empty($responseData['BookingReference'])) {
                $booking->update([
                    'yalago_booking_reference' => $responseData['BookingReference'],
                    'booking_status' => 'confirmed',
                ]);

                return [
                    'success' => true,
                    'data' => $responseData,
                    'booking_reference' => $responseData['BookingReference']
                ];
            }

            throw new Exception('Booking creation failed: No booking reference received');
        } catch (Exception $e) {
            Log::error('Hotel Booking Order Placement Error', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $booking->update([
                'booking_status' => 'failed',
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send booking confirmation email to user
     */
    public function sendBookingConfirmationEmail(HotelBooking $booking)
    {
        try {
            Mail::send('emails.hotel-booking-success-user', ['booking' => $booking], function ($message) use ($booking) {
                $message->to($booking->lead_email)
                    ->subject('Hotel Booking Confirmation - ' . $booking->booking_number);
            });

            Log::info('Booking confirmation email sent to user', [
                'booking_id' => $booking->id,
                'email' => $booking->lead_email
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send booking confirmation email to user', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send booking confirmation email to admin
     */
    public function sendBookingConfirmationEmailToAdmin(HotelBooking $booking)
    {
        try {
            $adminEmail = $this->adminEmail;

            Mail::send('emails.hotel-booking-success-admin', ['booking' => $booking], function ($message) use ($booking, $adminEmail) {
                $message->to($adminEmail)
                    ->subject('New Hotel Booking - ' . $booking->booking_number);
            });

            Log::info('Booking confirmation email sent to admin', [
                'booking_id' => $booking->id,
                'email' => $adminEmail
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send booking confirmation email to admin', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send booking failure email to user
     */
    public function sendBookingFailureEmail(HotelBooking $booking, string $reason = '')
    {
        try {
            Mail::send('emails.hotel-booking-failed-user', [
                'booking' => $booking,
                'reason' => $reason
            ], function ($message) use ($booking) {
                $message->to($booking->lead_email)
                    ->subject('Hotel Booking Failed - ' . $booking->booking_number);
            });

            Log::info('Booking failure email sent to user', [
                'booking_id' => $booking->id,
                'email' => $booking->lead_email
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send booking failure email to user', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send booking failure email to admin
     */
    public function sendBookingFailureEmailToAdmin(HotelBooking $booking, string $reason = '')
    {
        try {
            $adminEmail = $this->adminEmail;

            Mail::send('emails.hotel-booking-failed-admin', [
                'booking' => $booking,
                'reason' => $reason
            ], function ($message) use ($booking, $adminEmail) {
                $message->to($adminEmail)
                    ->subject('Hotel Booking Failed - ' . $booking->booking_number);
            });

            Log::info('Booking failure email sent to admin', [
                'booking_id' => $booking->id,
                'email' => $adminEmail
            ]);
        } catch (Exception $e) {
            Log::error('Failed to send booking failure email to admin', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getCancellationCharges(HotelBooking $booking): array
    {
        $response = Http::withHeaders([
            'x-api-key'   => $this->yalagoApiKey,
            'Accept'      => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(
            'https://api.yalago.com/hotels/bookings/getcancellationcharges',
            [
                'BookingRef'      => $booking->yalago_booking_reference,
                'GetTaxBreakdown' => true,
            ]
        );

        if (!$response->successful()) {
            Log::error('Yalago getCancellationCharges failed', [
                'booking_id' => $booking->id,
                'response'   => $response->body(),
            ]);

            throw new \Exception('Unable to fetch cancellation charges');
        }

        return $response->json();
    }

    public function cancelYalagoBooking(HotelBooking $booking, array $charges): array
    {
        if (!($charges['IsCancellable'] ?? false)) {
            throw new \Exception('Booking is not cancellable');
        }

        $today = now()->toDateString();
        $currentCharge = null;

        foreach ($charges['CancellationPolicyStatic'][0]['CancellationCharges'] as $charge) {
            if ($today <= substr($charge['ExpiryDate'], 0, 10)) {
                $currentCharge = $charge['Charge'];
                break;
            }
        }

        if (!$currentCharge) {
            throw new \Exception('No valid cancellation charge found');
        }

        $response = Http::withHeaders([
            'x-api-key'    => $this->yalagoApiKey,
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(
            'https://api.yalago.com/hotels/bookings/cancel',
            [
                'BookingRef' => $booking->yalago_booking_reference,
                'ExpectedCharge' => [
                    'Charge' => [
                        'Amount'   => $currentCharge['Amount'],
                        'Currency' => $currentCharge['Currency'],
                    ],
                ],
            ]
        );

        if (!$response->successful()) {
            throw new \Exception('Supplier cancellation failed');
        }

        return $response->json();
    }
}

<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrioTicketService
{
    private $baseUrl = 'https://distributor-api.prioticket.com/v3.5/distributor';
    private $authToken = 'YW5kYWxlZWIyMDIzMDFAcHJpb2FwaXMuY29tOkBBbmQwVHJhdjMkTEAhMiM=';
    private $distributorId = '49670';

    public function getAccessToken()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $this->authToken
            ])->post($this->baseUrl . '/oauth2/token');

            if ($response->successful()) {
                return $response->json('access_token');
            }

            Log::error('PrioTicket: Failed to get access token', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PrioTicket: Exception getting access token', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function fetchProduct(string $productId, string $accessToken): array
    {
        try {
            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->get($this->baseUrl . "/products/{$productId}");

            if (! $response->successful()) {
                Log::error('PrioTicket: Product fetch failed', [
                    'product_id' => $productId,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [
                    'success' => false,
                    'error' => 'Product not found or unavailable'
                ];
            }

            return [
                'success' => true,
                'data' => $response->json('data')
            ];
        } catch (\Exception $e) {
            Log::error('PrioTicket: Exception fetching product', [
                'product_id' => $productId,
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function validateProductTypes(array $cartProductTypes, array $liveProductTypes): bool
    {
        foreach ($cartProductTypes as $cartType) {
            $exists = collect($liveProductTypes)->contains(
                fn($liveType) => $liveType['id'] === $cartType['id']
            );

            if (! $exists) {
                return false;
            }
        }

        return true;
    }

    public function createReservation($orderData, $accessToken)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post($this->baseUrl . '/reservations', $orderData);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::error('PrioTicket: Failed to create reservation', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => $response->body()
            ];
        } catch (\Exception $e) {
            Log::error('PrioTicket: Exception creating reservation', [
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function buildReservationPayload($order, $orderItems, $passengerData)
    {
        $reservationDetails = [];

        // Get country name from country ID
        $country = Country::find($passengerData['country_code']);
        $countryName = $country ? $country->name : 'United Arab Emirates';
        $countryCode = $country ? $country->iso_code : 'AE';

        foreach ($orderItems as $item) {
            $reservationDetails[] = [
                'booking_external_reference' => $order->order_number,
                'booking_language' => 'en',
                'product_availability_id' => $item['availability_id'],
                'product_id' => (string) $item['product_id_prio'],
                'product_type_details' => $item['product_type_details'],
                'booking_reservation_reference' => $order->order_number
            ];
        }

        return [
            'data' => [
                'reservation' => [
                    'reservation_distributor_id' => $this->distributorId,
                    'reservation_external_reference' => $order->order_number,
                    'reservation_details' => $reservationDetails,
                    'reservation_contacts' => [
                        [
                            'contact_uid' => '',
                            'contact_number' => $passengerData['phone'],
                            'contact_name_first' => $passengerData['first_name'],
                            'contact_name_last' => $passengerData['last_name'],
                            'contact_email' => $passengerData['email'],
                            'contact_phone' => $passengerData['phone'],
                            'contact_mobile' => $passengerData['phone'],
                            'contact_address' => [
                                'name' => $passengerData['address'] ?? '',
                                'city' => $passengerData['city'] ?? 'N/A',
                                'region' => $passengerData['region'] ?? 'N/A',
                                'postal_code' => $passengerData['postal_code'] ?? 'N/A',
                                'country' => $countryName,
                                'country_code' => $countryCode
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Confirm PrioTicket orders after payment is successful
     */
    public function confirmOrder($order)
    {
        try {
            $token = $this->getAccessToken();

            if (!$token) {
                throw new \Exception('Failed to get PrioTicket access token');
            }

            foreach ($order->orderItems as $orderItem) {
                if (empty($orderItem->reservation_data)) {
                    continue;
                }

                $reservationData = json_decode($orderItem->reservation_data, true);

                if (!isset($reservationData['data']['reservation']['reservation_reference'])) {
                    Log::warning('Missing reservation reference for order item', [
                        'order_item_id' => $orderItem->id
                    ]);
                    continue;
                }

                $reservationReference = $reservationData['data']['reservation']['reservation_reference'];
                $externalReference = $reservationData['data']['reservation']['reservation_external_reference'] ?? null;

                $orderData = [
                    'data' => [
                        'order' => [
                            'order_distributor_id' => $this->distributorId,
                            'order_external_reference' => $externalReference,
                            'order_settlement_type' => 'EXTERNAL',
                            'order_language' => 'en',
                            'order_contacts' => [
                                [
                                    'contact_uid' => '',
                                    'contact_number' => $order->passenger_phone,
                                    'contact_name_first' => $order->passenger_first_name,
                                    'contact_name_last' => $order->passenger_last_name,
                                    'contact_email' => $order->passenger_email,
                                    'contact_phone' => $order->passenger_phone,
                                    'contact_mobile' => $order->passenger_phone,
                                    'contact_address' => [
                                        'name' => $order->passenger_address,
                                        'city' => $order->passenger_country,
                                        'postal_code' => '00000',
                                        'region' => $order->passenger_country,
                                        'country' => $order->passenger_country,
                                        'country_code' => 'AE'
                                    ]
                                ]
                            ],
                            'order_options' => [
                                'email_options' => [
                                    'email_types' => [
                                        'send_tickets' => true,
                                        'send_receipt' => true,
                                        'send_marketing' => true,
                                        'send_offers' => true,
                                        'send_notification' => true
                                    ]
                                ],
                                'price_on_voucher' => true
                            ],
                            'order_activity_url' => url('/orders/' . $order->order_number),
                            'order_view_type' => 'DISTRIBUTOR',
                            'order_bookings' => [
                                [
                                    'booking_option_type' => 'CONFIRM_RESERVATION',
                                    'reservation_reference' => $reservationReference
                                ]
                            ]
                        ]
                    ]
                ];

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])->post($this->baseUrl . '/orders', $orderData);

                if ($response->successful()) {
                    $orderItem->update([
                        'order_data' => $response->body()
                    ]);

                    Log::info('PrioTicket order confirmed successfully', [
                        'order_item_id' => $orderItem->id,
                        'reservation_reference' => $reservationReference
                    ]);
                } else {
                    Log::error('PrioTicket order confirmation failed', [
                        'order_item_id' => $orderItem->id,
                        'response' => $response->body()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('PrioTicket Order Confirmation Error', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function checkAvailability(
        string $productId,
        string $availabilityId,
        string $date,
        int $pax,
        string $accessToken
    ): array {
        try {
            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->get($this->baseUrl . "/products/{$productId}/availability", [
                    'distributor_id' => $this->distributorId,
                    'from_date'      => $date,
                ]);

            if (! $response->successful()) {
                return [
                    'success' => false,
                    'error' => 'Availability fetch failed',
                ];
            }

            $availabilities = $response->json('data.items', []); 

            $availability = collect($availabilities)
                ->firstWhere('availability_id', $availabilityId);

            if (! $availability) {
                return [
                    'success' => false,
                    'error' => 'Selected time slot is no longer available',
                ];
            }

            if (($availability['availability_spots']['availability_spots_open'] ?? 0) < $pax) { 
                return [
                    'success' => false,
                    'error' => 'Not enough seats available',
                ];
            }

            return ['success' => true];
        } catch (\Throwable $e) {
            Log::error('PrioTicket availability check failed', [
                'product_id' => $productId,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Availability check failed',
            ];
        }
    }
}

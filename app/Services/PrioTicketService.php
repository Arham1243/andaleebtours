<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrioTicketService
{
    private $baseUrl = 'https://distributor-api.prioticket.com/v3.5/distributor';
    private $authToken = 'YW5kYWxlZWIyMDIzMDFAcHJpb2FwaXMuY29tOkBBbmQwVHJhdjMkTEAhMiM=';

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

    public function createReservation($orderData, $accessToken)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
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
        $rand = rand(110, 7120356789);
        $reservationDetails = [];

        // Get country name from country ID
        $country = Country::find($passengerData['country_code']);
        $countryName = $country ? $country->name : 'United Arab Emirates';
        $countryCode = $country ? $country->iso_code : 'AE';

        foreach ($orderItems as $item) {
            $reservationDetails[] = [
                'booking_external_reference' => 'ANDALEEBBER' . $rand . '-' . $item['tour_id'],
                'booking_language' => 'en',
                'product_availability_id' => $item['availability_id'],
                'product_id' => $item['product_id_prio'],
                'product_type_details' => $item['product_type_details'],
                'booking_reservation_reference' => 'ANDALEEBBRR' . $rand . '-' . $item['tour_id']
            ];
        }

        return [
            'data' => [
                'reservation' => [
                    'reservation_distributor_id' => '49670',
                    'reservation_external_reference' => 'ANDALEEBRER' . $rand,
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
                                'city' => $passengerData['city'] ?? 'Dubai',
                                'region' => $passengerData['region'] ?? 'Dubai',
                                'postal_code' => $passengerData['postal_code'] ?? '00000',
                                'country' => $countryName,
                                'country_code' => $countryCode
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}

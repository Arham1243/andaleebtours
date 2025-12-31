<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaymentService
{
    /**
     * Get redirect URL based on payment method
     */
    public function getRedirectUrl(Order $order, string $paymentMethod): string
    {
        switch ($paymentMethod) {
            case 'payby':
                return $this->paybyRedirect($order);

            case 'tabby':
                return $this->tabbyRedirect($order);

            default:
                throw new \InvalidArgumentException("Unsupported payment method: {$paymentMethod}");
        }
    }

    /**
     * CREDIT/DEBIT - PayBy Gateway
     */
    protected function paybyRedirect(Order $order)
    {
        $requestTime = now()->timestamp * 1000;
        
        $orderItems = $order->orderItems()->with('tour')->get();
        $tourNames = $orderItems->pluck('tour_name')->implode(', ');
        $tourNames = strlen($tourNames) > 50 ? substr($tourNames, 0, 40) . '...' : $tourNames;
        
        $requestData = [
            'requestTime' => $requestTime,
            'bizContent' => [
                'merchantOrderNo' => $order->order_number,
                'subject' => 'TOUR BOOKING',
                'totalAmount' => [
                    'currency' => 'AED',
                    'amount' => number_format((float)$order->total, 2, '.', '')
                ],
                'paySceneCode' => 'PAYPAGE',
                'paySceneParams' => [
                    'redirectUrl' => route('frontend.payment.callback.payby', ['order' => $order->id])
                ],
                'reserved' => 'Andaleeb Travel Agency Order',
                'notifyUrl' => route('frontend.payment.notify.payby'),
                'accessoryContent' => [
                    'amountDetail' => [
                        'vatAmount' => $order->vat > 0 ? [
                            'currency' => 'AED',
                            'amount' => number_format((float)$order->vat, 2, '.', '')
                        ] : null,
                        'amount' => $order->service_tax > 0 ? [
                            'currency' => 'AED',
                            'amount' => number_format((float)$order->service_tax, 2, '.', '')
                        ] : null
                    ],
                    'goodsDetail' => [
                        'body' => 'Tour Booking',
                        'categoriesTree' => 'CT12',
                        'goodsCategory' => 'GC10',
                        'goodsId' => 'GI1005',
                        'goodsName' => $tourNames,
                        'price' => [
                            'currency' => 'AED',
                            'amount' => number_format((float)$order->subtotal, 2, '.', '')
                        ],
                        'quantity' => $orderItems->count()
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
        
        $privateKeyPath = public_path('admin/assets/files/payby-private-key.pem');
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
            'Partner-Id' => '200009116289',
            'sign' => $base64Signature,
        ])->post('https://api.payby.com/sgs/api/acquire2/placeOrder', $requestData);
        
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
     * TABBY
     */
    protected function tabbyRedirect(Order $order)
    {
        // TODO: implement Tabby API logic
        return 'https://google.com';
    }
}

<?php

namespace App\Services\Payment;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PhonePeService
{
    protected $client;
    protected $merchantId;
    protected $merchantKey;
    protected $merchantSalt;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->merchantId = config('phonepe.merchant_id');
        $this->merchantKey = config('phonepe.merchant_key');
        $this->merchantSalt = config('phonepe.merchant_salt');
        $this->baseUrl = config('phonepe.base_url');
    }

    public function initiatePayment($amount, $callbackUrl, $orderId)
    {
        $url = $this->baseUrl . '/v3/transaction/initiate';
        $data = [
            'merchantId' => $this->merchantId,
            'transactionId' => $orderId,
            'amount' => $amount * 100, // Amount in paise
            'merchantOrderId' => $orderId,
            'merchantCallbackUrl' => $callbackUrl,
        ];

        $checksum = $this->generateChecksum($data);
        $headers = [
            'Content-Type' => 'application/json',
            'X-VERIFY' => $checksum . '###' . $this->merchantKey
        ];

        try {
            $response = $this->client->post($url, [
                'headers' => $headers,
                'body' => json_encode($data)
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error('PhonePe initiate payment error: ' . $e->getMessage());
            return false;
        }
    }

    protected function generateChecksum($data)
    {
        $dataString = json_encode($data);
        return hash_hmac('sha256', $dataString, $this->merchantSalt);
    }
}

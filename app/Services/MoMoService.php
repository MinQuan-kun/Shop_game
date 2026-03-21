<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoMoService
{
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    private $endpoint;

    public function __construct()
    {
        $this->partnerCode = env('MOMO_PARTNER_CODE', 'MOMOBKUN20180529');
        $this->accessKey = env('MOMO_ACCESS_KEY', 'klm05TvNBzhg7h7j');
        $this->secretKey = env('MOMO_SECRET_KEY', 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa');
        $this->endpoint = env('MOMO_ENDPOINT', 'https://test-payment.momo.vn');
    }

    /**
     * Create MoMo payment request
     */
    public function createPayment($orderId, $amount, $orderInfo, $returnUrl, $notifyUrl)
    {
        $requestId = time() . "";
        $requestType = "captureWallet";
        $extraData = "";

        // Generate signature
        $rawHash = "accessKey=" . $this->accessKey .
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&ipnUrl=" . $notifyUrl .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $this->partnerCode .
            "&redirectUrl=" . $returnUrl .
            "&requestId=" . $requestId .
            "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

        $data = [
            'partnerCode' => $this->partnerCode,
            'accessKey' => $this->accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $returnUrl,
            'ipnUrl' => $notifyUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'lang' => 'vi'
        ];

        try {
            $response = Http::post($this->endpoint . '/v2/gateway/api/create', $data);

            Log::info('MoMo Payment Request', ['data' => $data, 'response' => $response->json()]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('MoMo Payment Error', ['error' => $e->getMessage()]);
            return [
                'resultCode' => 99,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify MoMo callback signature
     */
    public function verifySignature($data)
    {
        $rawHash = "accessKey=" . $this->accessKey .
            "&amount=" . $data['amount'] .
            "&extraData=" . ($data['extraData'] ?? '') .
            "&message=" . $data['message'] .
            "&orderId=" . $data['orderId'] .
            "&orderInfo=" . $data['orderInfo'] .
            "&orderType=" . $data['orderType'] .
            "&partnerCode=" . $this->partnerCode .
            "&payType=" . $data['payType'] .
            "&requestId=" . $data['requestId'] .
            "&responseTime=" . $data['responseTime'] .
            "&resultCode=" . $data['resultCode'] .
            "&transId=" . $data['transId'];

        $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

        return $signature === $data['signature'];
    }

    /**
     * Query transaction status
     */
    public function queryTransaction($orderId, $requestId)
    {
        $rawHash = "accessKey=" . $this->accessKey .
            "&orderId=" . $orderId .
            "&partnerCode=" . $this->partnerCode .
            "&requestId=" . $requestId;

        $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

        $data = [
            'partnerCode' => $this->partnerCode,
            'accessKey' => $this->accessKey,
            'requestId' => $requestId,
            'orderId' => $orderId,
            'signature' => $signature,
            'lang' => 'vi'
        ];

        try {
            $response = Http::post($this->endpoint . '/v2/gateway/api/query', $data);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('MoMo Query Error', ['error' => $e->getMessage()]);
            return ['resultCode' => 99];
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Services\MoMoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    /**
     * Initiate PayPal deposit
     */
    public function paypalDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $amountUSD = $request->amount;

        // Exchange rate USD to VND (example: 1 USD = 25,000 VND)
        $exchangeRate = 25000;
        $amountVND = $amountUSD * $exchangeRate;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        try {
            $order = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('payment.paypal.success'),
                    "cancel_url" => route('payment.paypal.cancel'),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => number_format($amountUSD, 2, '.', '')
                        ],
                        "description" => "Nạp tiền vào ví - " . number_format($amountVND, 0, ',', '.') . " VNĐ"
                    ]
                ]
            ]);

            if (isset($order['id']) && $order['id'] != null) {
                // Save pending transaction
                Transaction::create([
                    'user_id' => Auth::id(),
                    'type' => 'deposit',
                    'amount' => $amountVND,
                    'status' => 'pending',
                    'description' => 'Nạp tiền qua PayPal - $' . $amountUSD,
                    'reference_id' => $order['id'],
                    'payment_method' => 'paypal',
                    'metadata' => [
                        'amount_usd' => $amountUSD,
                        'amount_vnd' => $amountVND,
                        'exchange_rate' => $exchangeRate
                    ]
                ]);

                // Redirect to PayPal
                foreach ($order['links'] as $link) {
                    if ($link['rel'] == 'approve') {
                        return redirect($link['href']);
                    }
                }
            }

            return redirect()->route('wallet.deposit')
                ->with('error', 'Không thể tạo giao dịch PayPal.');

        } catch (\Exception $e) {
            Log::error('PayPal Error: ' . $e->getMessage());
            return redirect()->route('wallet.deposit')
                ->with('error', 'Lỗi PayPal: ' . $e->getMessage());
        }
    }

    /**
     * PayPal success callback
     */
    public function paypalSuccess(Request $request)
    {
        try {
            Log::info('PayPal Success Callback Started', [
                'token' => $request->token,
                'all_params' => $request->all()
            ]);

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->capturePaymentOrder($request->token);

            Log::info('PayPal Capture Response', [
                'status' => $response['status'] ?? 'N/A',
                'response' => $response
            ]);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                // Find transaction by reference_id (which is the PayPal order ID from token)
                $transaction = Transaction::where('reference_id', $request->token)
                    ->where('status', 'pending')
                    ->first();

                Log::info('Transaction Lookup', [
                    'reference_id' => $request->token,
                    'found' => $transaction ? 'YES' : 'NO',
                    'transaction_id' => $transaction?->id
                ]);

                if ($transaction) {
                    DB::beginTransaction();

                    // Update transaction to completed
                    $transaction->update([
                        'status' => 'completed',
                        'metadata' => array_merge($transaction->metadata ?? [], [
                            'paypal_order_id' => $response['id'],
                            'capture_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
                        ])
                    ]);

                    // Add balance to user
                    $user = User::find($transaction->user_id);
                    $oldBalance = $user->balance;
                    $user->addBalance($transaction->amount);
                    $user->refresh();

                    Log::info('Balance Updated', [
                        'user_id' => $user->id,
                        'old_balance' => $oldBalance,
                        'new_balance' => $user->balance,
                        'amount_added' => $transaction->amount
                    ]);

                    DB::commit();

                    return redirect()->route('wallet.index')
                        ->with('success', '✅ Nạp tiền thành công! Số dư mới: ' . number_format($user->balance, 0, ',', '.') . ' VNĐ');
                }

                Log::warning('Transaction not found or already processed');
            }

            return redirect()->route('wallet.deposit')->with('error', 'Không tìm thấy giao dịch hoặc đã xử lý');

        } catch (\Exception $e) {
            Log::error('PayPal Success Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('wallet.deposit')->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Handle cancelled PayPal payment
     */
    public function paypalCancel(Request $request)
    {
        // Update transaction status to cancelled
        if ($request->has('token')) {
            Transaction::where('reference_id', $request->token)
                ->where('status', 'pending')
                ->update(['status' => 'cancelled']);
        }

        return redirect()->route('wallet.deposit')
            ->with('info', 'Bạn đã hủy giao dịch PayPal.');
    }

    /**
     * Initiate MoMo deposit
     */
    public function momoDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000'
        ]);

        $amount = $request->amount;
        $orderId = 'DEPOSIT_' . time() . '_' . Auth::id();
        $orderInfo = 'Nạp tiền vào ví';
        $returnUrl = route('payment.momo.return');
        $notifyUrl = route('payment.momo.callback');

        $momoService = new MoMoService();
        $response = $momoService->createPayment($orderId, $amount, $orderInfo, $returnUrl, $notifyUrl);

        if ($response['resultCode'] == 0) {
            // Save pending transaction
            Transaction::create([
                'user_id' => Auth::id(),
                'type' => 'deposit',
                'amount' => $amount,
                'status' => 'pending',
                'description' => 'Nạp tiền qua MoMo',
                'reference_id' => $orderId,
                'payment_method' => 'momo',
                'metadata' => [
                    'request_id' => $response['requestId']
                ]
            ]);

            // Redirect to MoMo payment page
            return redirect($response['payUrl']);
        }

        return redirect()->route('wallet.deposit')
            ->with('error', 'Không thể tạo giao dịch MoMo: ' . ($response['message'] ?? 'Unknown error'));
    }

    /**
     * Handle MoMo callback (IPN)
     */
    public function momoCallback(Request $request)
    {
        $momoService = new MoMoService();

        // Verify signature
        if (!$momoService->verifySignature($request->all())) {
            Log::error('MoMo Invalid Signature', $request->all());
            return response()->json(['resultCode' => 97]);
        }

        if ($request->resultCode == 0) {
            // Payment successful
            $transaction = Transaction::where('reference_id', $request->orderId)
                ->where('status', 'pending')
                ->first();

            if ($transaction) {
                DB::beginTransaction();

                try {
                    // Update transaction
                    $transaction->update([
                        'status' => 'completed',
                        'metadata' => array_merge($transaction->metadata ?? [], [
                            'trans_id' => $request->transId
                        ])
                    ]);

                    // Add balance
                    $user = User::find($transaction->user_id);
                    $user->addBalance($transaction->amount);

                    DB::commit();

                    Log::info('MoMo Payment Success', [
                        'order_id' => $request->orderId,
                        'trans_id' => $request->transId
                    ]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('MoMo Callback Error: ' . $e->getMessage());
                    return response()->json(['resultCode' => 99]);
                }
            }
        } else {
            // Payment failed
            Transaction::where('reference_id', $request->orderId)
                ->where('status', 'pending')
                ->update(['status' => 'failed']);
        }

        return response()->json(['resultCode' => 0]);
    }

    /**
     * Handle MoMo return URL
     */
    public function momoReturn(Request $request)
    {
        if ($request->resultCode == 0) {
            $transaction = Transaction::where('reference_id', $request->orderId)
                ->first();

            if ($transaction && $transaction->status == 'completed') {
                $user = Auth::user();
                return redirect()->route('wallet.index')
                    ->with('success', 'Nạp tiền thành công! Số dư mới: ' . number_format($user->balance, 0, ',', '.') . ' VNĐ');
            } else {
                return redirect()->route('wallet.deposit')
                    ->with('info', 'Giao dịch đang được xử lý, vui lòng đợi...');
            }
        } else {
            return redirect()->route('wallet.deposit')
                ->with('error', 'Giao dịch thất bại: ' . ($request->message ?? 'Unknown error'));
        }
    }
}

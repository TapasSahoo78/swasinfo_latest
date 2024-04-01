<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Exception;
use Illuminate\Support\Facades\Validator;

class WalletController extends BaseController
{
    public function rechargeWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }
        try {
            // Get the user making the recharge
            $user = auth()->user();

            // Create a Razorpay order
            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

            $order = $api->order->create([
                'amount' => $request->amount * 100, // Amount in paisa
                'currency' => 'INR',
            ]);
            return $this->responseJson(true, 200, "Payment intent created successfully!", $order);
        } catch (Exception $e) {
            return $this->responseJson(false, 422, "Something went wrong!", $e->getMessage());
        }
    }
    public function payMentVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'razorpay_order_id' => 'required',
            'razorpay_payment_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->all(), "");
        }

        $razorpay_order_id = $request->razorpay_order_id;
        $razorpay_payment_id = $request->razorpay_payment_id;

        // Initialize Razorpay API
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        try {
            // Fetch the payment
            $payment = $api->payment->fetch($razorpay_payment_id);
            $amount = $payment->amount;

            // Verify the payment
            $attributes = [
                'razorpay_order_id' => $razorpay_order_id,
                'razorpay_payment_id' => $razorpay_payment_id,
            ];

            $api->utility->verifyPaymentSignature($attributes);
            $user = auth()->user();
            $user->wallet->balance += $amount;
            $user->wallet->save();

            // Record the transaction
            WalletTransaction::create([
                'wallet_id' => $user?->wallet?->id,
                'amount' => $amount / 100,
                'type' => 'credit',
                'description' => 'Wallet recharge via Razorpay',
            ]);

            return $this->responseJson(false, 422, "Payment verification successful", $payment->toArray());
        } catch (\Exception $e) {
            return $this->responseJson(false, 422, "Payment verification failed!", $e->getMessage());
        }
    }

    public function getWalletHistory(Request $request)
    {
        $user = auth()->user();
        if (empty($user->wallet)) {
            return response()->json([
                'success' => false,
                'message' => 'User does not have a wallet',
            ], 422);
        }
        $wallet = $user?->wallet;
        $walletTransaction = $user?->wallet?->walletHistory;
        return $this->responseJson(false, 200, "Get Wallet History", [
            'wallet' => $wallet,
            'walletTransaction' => $walletTransaction
        ]);
    }
}

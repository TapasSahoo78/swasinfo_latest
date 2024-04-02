<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WalletController extends BaseController
{
    public function rechargeWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:Step Count,Calories Burned,Distance Covered,Body Scan,Face Scan,Posture Analysis,Brain Games',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), (object)[]);
        }
        DB::begintransaction();
        try {
            $user = auth()->user();

            if (!$user->wallet) {
                $wallet = new Wallet([
                    'user_id' => $user?->id,
                    'balance' => $request->amount,
                ]);
                $wallet->save();
            } else {
                // Update the existing wallet's balance
                $user->wallet->balance += $request->amount;
                $user->wallet->save();
                $wallet = $user->wallet;
            }
            $walletTrans = WalletTransaction::where('category', $request->category)
                ->where('wallet_id', $wallet?->id)
                ->first();
            logger($walletTrans?->amount ."||". $request->amount);
            if (!empty($walletTrans)) {
                $walletTrans->update([
                    'amount' => $walletTrans?->amount + $request->amount,
                    'type' => 'credit',
                    'description' => 'Coin Added',
                    'current_balance' => $walletTrans?->amount + $request->amount,
                ]);
            } else {
                WalletTransaction::create([
                    'wallet_id' => $wallet?->id,
                    'amount' => $request->amount,
                    'type' => 'credit',
                    'description' => 'Coin Added',
                    'category' => $request->category,
                    'current_balance' => $request->amount,
                ]);
            }
            DB::commit();
            return $this->responseJson(true, 200, "Coin added successfully!", (object)[]);
        } catch (Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->responseJson(false, 500, "Something went wrong!", $e->getMessage());
        }
    }
    public function getWalletHistory(Request $request)
    {
        $user = auth()->user();
        if (empty($user->wallet)) {
            return $this->responseJson(false, 422, "User does not have a wallet", (object)[]);
        }
        $wallet = $user?->wallet;
        $walletTransaction = $user?->wallet?->walletHistory;
        return $this->responseJson(false, 200, "Get Wallet History", [
            'wallet' => $wallet?->balance,
            'walletTransaction' => $walletTransaction
        ]);
    }
}

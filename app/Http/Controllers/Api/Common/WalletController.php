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
            'category' => 'required|in:Step Count,Calories Burned,Distance Covered,Body Scan,Face Scan,Food Scan,Posture Analysis,Brain Games',
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

            WalletTransaction::create([
                'wallet_id' => $wallet?->id,
                'amount' => $request->amount,
                'type' => 'credit',
                'description' => 'Coin Added',
                'category' => $request->category,
                'current_balance' => $request->amount,
            ]);
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
        $validator = Validator::make($request->all(), [
            'filter' => 'required|in:day,week,month'
        ]);

        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), (object)[]);
        }

        $user = auth()->user();
        if (empty($user->wallet)) {
            return $this->responseJson(false, 422, "User does not have a wallet", (object)[]);
        }

        $wallet = $user?->wallet;

        // Initialize start and end dates based on filter
        if ($request->filter === 'day') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($request->filter === 'week') {
            // For the week filter, get the start and end of the week
            $startDate = now()->startOfWeek()->startOfDay();
            $endDate = now()->endOfWeek()->endOfDay();
        } elseif ($request->filter === 'month') {
            $startDate = now()->startOfMonth()->startOfDay();
            $endDate = now()->endOfMonth()->endOfDay();
        } else {
            // Invalid filter value
            return $this->responseJson(false, 422, "Invalid filter value", (object)[]);
        }

        // Get the individual category totals
        $walletTransaction = WalletTransaction::where([
            'wallet_id' => $wallet->id,
            'type' => 'credit'
        ])->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'category',
                DB::raw('COALESCE(SUM(amount), 0) as total_amount')
            )
            ->groupBy('category')
            ->get();

        // Get the total sum of all amounts for all categories
        $totalValue = WalletTransaction::where([
            'wallet_id' => $wallet->id,
            'type' => 'credit'
        ])->whereBetween('created_at', [$startDate, $endDate])->sum('amount');

        return $this->responseJson(true, 200, "Get Wallet History", [
            'wallet' => $wallet?->balance ?? 0.00,
            'walletTransaction' => $walletTransaction ?? [],
            'total_amount' => $totalValue ?? 0.00,
        ]);
    }
}

<?php

namespace App\Traits;

use App\Coupon as AppCoupon;
use App\SchoolAccount;
use App\Transaction;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Coupon
{
    /**Process a coupon recharge */
    public static function recharge(string $code ,User $user = null ,SchoolAccount $schoolAccount = null)
    {
        DB::beginTransaction();

        try {
            
            $coupon = AppCoupon::where('code', $code)->first();
            // Check if code is valid
            if (empty($coupon)) {
                return [
                    "success" => false,
                    "msg" => "Invalid coupon code!"
                ];
            }

            if (!empty($user)) {
                if (!empty($coupon->user_id)) {
                    if ($coupon->user_id == $user->id) {
                        return [
                            "success" => false,
                            "msg" => "Coupon has been used by you!"
                        ];
                    } else {
                        return [
                            "success" => false,
                            "msg" => "Sorry, coupon has been used!"
                        ];
                    }
                }
                $coupon->user_id = $user->id;
            } else {
                if ($coupon->amount < $schoolAccount->amount) {
                    return [
                        "success" => false,
                        "msg" => "Coupon value is less than required amount!"
                    ];
                }
                if (!empty($coupon->school_account_id)) {
                    if ($coupon->school_account_id == $schoolAccount->id) {
                        return [
                            "success" => false,
                            "msg" => "Coupon has been used by you!"
                        ];
                    } else {
                        return [
                            "success" => false,
                            "msg" => "Sorry, coupon has been used!"
                        ];
                    }
                }

                $coupon->school_account_id = $schoolAccount->id;
            }

            $coupon->save();

            $recharge = [
                'user_id' => $user->id ?? null,
                'school_account_id' => $schoolAccount->id ?? null,
                'uuid' => getRandomToken(6),
                'amount' => $coupon->amount,
                'purpose' => 'Your recharge of NGN'. $coupon->amount .' was successful! Coupon Code: #'.$coupon->code,
                'type' => 'Deposit',
                'status' => 'Completed',
            ];

            $transaction = Transaction::create($recharge);

            DB::commit();
            return [
                "status" => true,
                "msg" => "Recharge Successful!",
                "coupon" => $coupon,
                "transaction" => $transaction,
            ];
        } catch (Exception $e) {
            DB::rollback();
            return [
                "success" => false,
                "msg" => "An error occurred!"
            ];
        }
    }
}
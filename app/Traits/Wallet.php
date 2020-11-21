<?php

namespace App\Traits;

use App\Coupon as AppCoupon;
use App\Helpers\AppConstants;
use App\SchoolAccount;
use App\Transaction;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Wallet
{
    public static function debit($user_id, $amount , $narration , $action, $reference_id = null){
        DB::beginTransaction();
        try{
            $user = User::find($user_id);
            if(!empty($user)){
                if($user->wallet >= $amount){
                    $user->wallet -= $amount;
                }
                else{
                    return [
                        "success" => false,
                        "msg" => "Insufficient funds!",
                    ];
                }
                $user->save();
                Transaction::create([
                    'user_id' => $user->id,
                    'uuid' => getRandomToken(6),
                    'amount' => $amount,
                    'purpose' => $narration,
                    'type' => AppConstants::DEBIT_TRANSACTION,
                    'status' => AppConstants::COMPLETED_TRANSACTION,
                    'action' => $action,
                    'reference_id' => $reference_id
                ]);
                DB::commit();
                return [
                    "success" => true,
                    "msg" => "Transaction successful!",
                ];
            }
        }
        catch(Exception $e){
            DB::rollback(); 
            return [
                "success" => false,
                "msg" => "An error occurred!",
            ];
        }

    }

    public static function credit($user_id, $amount , $narration , $action , $reference_id = null){
        DB::beginTransaction();
        try{
            $user = User::find($user_id);
            if(!empty($user)){
                $user->wallet += $amount;
                $user->save();
                Transaction::create([
                    'user_id' => $user->id,
                    'uuid' => getRandomToken(6),
                    'amount' => $amount,
                    'purpose' => $narration,
                    'type' => AppConstants::CREDIT_TRANSACTION,
                    'status' => AppConstants::COMPLETED_TRANSACTION,
                    'action' => $action,
                    'reference_id' => $reference_id
                ]);
                DB::commit();
                return [
                    "success" => true,
                    "msg" => "Transaction successful!",
                ];
            }
        }
        catch(Exception $e){
            DB::rollback(); 
            return [
                "success" => false,
                "msg" => "An error occurred!",
            ];
        }

    }
}
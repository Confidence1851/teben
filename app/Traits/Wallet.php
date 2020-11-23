<?php

namespace App\Traits;

use App\Helpers\AppConstants;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Wallet
{
    public static function debit(int $user_id,int $amount ,string $narration ,int $action,int $reference_id = null){
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
                Transaction::store(
                    $user,
                    null,
                    $amount,
                    $narration,
                    AppConstants::DEBIT_TRANSACTION,
                    AppConstants::COMPLETED_TRANSACTION,
                    $action,
                    $reference_id
                );
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
                Transaction::store(
                    $user,
                    null,
                    $amount,
                    $narration,
                    AppConstants::CREDIT_TRANSACTION,
                    AppConstants::COMPLETED_TRANSACTION,
                    $action,
                    $reference_id
                );
                DB::commit();
                return [
                    "success" => true,
                    "msg" => "Transaction successful!",
                ];
            }
        }
        catch(Exception $e){
            DB::rollback(); 
            logError($e);
            return [
                "success" => false,
                "msg" => "An error occurred!",
            ];
        }

    }
}
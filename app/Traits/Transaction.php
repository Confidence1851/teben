<?php

namespace App\Traits;

use App\Helpers\AppConstants;
use App\Models\SchoolAccount;
use App\Models\Transaction as AppTransaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class Transaction
{
    public static function store(User $user = null , 
        SchoolAccount $schoolAccount = null,
        int $amount,
        string $purpose,
        int $type,
        int $status,
        int $action,
        int $reference_id = null)
    {
        $tranaction = AppTransaction::create([
            'user_id' => $user->id ?? null,
            'school_account_id' => $schoolAccount->id ?? null,
            'uuid' => getUniqueCode(6, true, new AppTransaction),
            'amount' => $amount,
            'purpose' => $purpose,
            'type' => $type,
            'status' => $status,
            'action' => $action,
            'reference_id' => $reference_id
        ]);

        // Send notifications

        return $tranaction;
    }
}

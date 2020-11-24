<?php

namespace App\Http\Controllers\User;

use App\Bank;
use App\Coupon as AppCoupon;
use App\User;
use App\Helpers\AppConstants;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Referral;
use App\RefWallet;
use App\Traits\Coupon;
use App\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth','verified']);
        // $banks = Bank::get();
        // foreach($banks as $bank){
        //     $bName = explode(',',$bank->bank_name);
        //     if(count($bName)  == 2 ){
        //         $bank->update(["bank_name" => $bName[1]]);
        //     }
        // }
        // $transactions = Transaction::get();
        // foreach ($transactions as $transaction) {
        //     $transaction->type = $transaction->type == "Debit" ? AppConstants::DEBIT_TRANSACTION : AppConstants::CREDIT_TRANSACTION;
        //     $transaction->status = AppConstants::COMPLETED_TRANSACTION;
        //     $transaction->uuid = getUniqueCode(6 , true ,new Transaction);
        //     $transaction->save();
        // }
        // $users = User::get();
        // foreach ($users as $user) {
        //     $user->uuid = getUniqueCode(10 , false ,new User);
        //     $user->save();
        // }

        // $coupons = AppCoupon::get();
        // foreach ($coupons as $coupon) {
        //     if(!empty($coupons->user_id) || !empty($coupon->school_account_id)){
        //         $coupon->use_date = $coupon->updated_at;
        //         $coupon->save();
        //     }
        // }

        // $referrals = Referral::get();
        // foreach ($referrals as $referral) {
        //     $referral->parent_points = AppConstants::INDIRECT_REFERRAL_BONUS;
        //     $referral->save();
        // }

        // $refWallets = RefWallet::get();
        // foreach ($refWallets as $wallet) {
        //     $wallet->amount = ($wallet->direct_refs + $wallet->indirect_refs) * 10 ;
        //     $wallet->save();
        // }
    }


    public function complete_profile(Request $request)
    {
        $user = auth()->user();
        $currentStatus = getUserProfileStatuses($user, true);

        if (is_bool($currentStatus) && $currentStatus == true) {
            return redirect()->route("home");
        }

        if ($request->getMethod() == "GET") {
            return view("user.profile.complete", compact("currentStatus", "user"));
        }

        if ($request->status_key == "role") {
            $data = $request->validate([
                "role" => "required|string",
            ]);
            switch ($data["role"]) {
                case "0": $data["role"] = AppConstants::DEFAULT_USER_TYPE; break;
                case "1": $data["role"] = AppConstants::PARENT_USER_TYPE; break;
                case "2": $data["role"] = AppConstants::TEACHER_USER_TYPE; break;
            }
            $user->update($data);
        }

        return redirect()->route("home");
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        if($user->role == "Admin"){
            return redirect()->route("admin") ;
        }
        $user->ref_status = optional($user->referral)->status;
        // $this->checkRequest();
        return view('user.dashboard', compact('user'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function referrals($id = null)
    {
        if (!empty($id)) {
            $user = User::findorfail($id);
        } else {
            $user = auth()->user();
        }
        $referrals = Referral::where("referrer_id", $user->id)->paginate(10);
        if(auth()->check()){
            $data = getUserRefData($user);
        }
        else{
            $data = null;
        }
        return view("user.referrals.index", compact('user', 'referrals' , 'data'));
    }
}

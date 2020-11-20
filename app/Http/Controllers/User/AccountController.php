<?php

namespace App\Http\Controllers\User;

use App\Bank;
use App\Http\Controllers\Controller;
use App\PayReceipt;
use App\Traits\Coupon;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function activateReferralAccount(Request $request){
        $data = $request->validate([
            "code" => "required|string",
        ]);

        $user = auth()->user();
        $referral = $user->referral;
        
        if (empty($referral)) {
            $referral = processReferral($user, developerAccount(), 0);
        }

        if(!empty($referral)){
            $process = Coupon::recharge($data["code"] , $user);
            if(!$process["status"]){
                return back()->with("error_msg" , $process["msg"]);
            }
            $referral->coupon = $process["coupon"]->code;
            $referral->amount = $process["coupon"]->amount;
            $referral->status = $this->activeStatus;
            $referral->save();
            return back()->with("success_msg" , "Account activated successfully!");
        }
        return back()->with("error_msg" , "Referral account not found!");
    }

    public function deposit(Request $request){
        $data = $request->validate([
            "code" => "nullable|string",
            'receipt' => 'nullable|image'
        ]);

        $user = auth()->user();
        if(!empty($data["code"])){
            $process = Coupon::recharge($data["code"] , $user);
            if(!$process["status"]){
                return back()->with("error_msg" , $process["msg"]);
            }
            $user->wallet += $process["coupon"]->amount;
            $user->save();
            return back()->with("success_msg" , "Account credited successfully!");
        }
        elseif(!empty($data["receipt"])){
            $image = $request->file('receipt');
            $filename = putFileInPrivateStorage($image , $this->receiptImagePath);
            $data['user_id'] = $user->id;
            $data['image'] = $filename;
            $data['type'] = 'Uploaded';
    
            PayReceipt::create($data);
            return redirect()->back()->with("success_msg" , "Receipt uploaded, deposit would be processed soon!!");
        }
        else{
            return back()->with("error_msg" , "Please provide either a coupon code or upload a receipt of your bank payment to process deposit!");
        }
        
    }

    public function profile(Request $request){
        $user = auth()->user();
        if($request->getMethod() == "GET"){ 
            $banks = getBanksList();
            return view("user.profile.index" , ["page" => "profile"  , "user" => $user ,"banks" => $banks]);
        }
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'gender' => 'required|string',
            'dob' => 'required|string',
            // 'marital_status' => 'required',
            // 'state' => 'required',
            // 'address' => 'required',
            // 'country' => 'required',
            // 'lga' => 'required',
            // 'town' => 'required',
        ]);
        
        $user->update($data);

        return back()->with("success_msg" , "Profile updated successfully!");

    }


    public function bank(Request $request){
        $user = auth()->user();
        if($request->getMethod() == "GET"){ 
            return view("user.profile.index" , ["page" => "bank"  , "user" => $user]);
        }
       

        $data = $request->validate([
            'bank_name' =>  'required',
            'account_name' =>  'required',
            'account_no' =>  'required|min:10|max:10',
        ]);

        $thisacct = Bank::where('account_no',$data['account_no'])->count();
        if($thisacct > 0){
            session()->flash('error_msg','Account number already exists!');
            return redirect()->back();
        }  

        $verified = verifyBankAccount($data["bank_name"] , $data["account_no"]);
        if($verified["status"]){
            $data["bank_name"] = getBanksList($data["bank_name"])["name"];
            $data["account_name"] = $verified["account_name"];
        }
        

        $data['user_id'] = $user->id;
        $bank = Bank::create($data);
        return back()->with("success_msg" , "Bank details updated successfully!");
    }


}
<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\SchoolAccount;
use Exception;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function login(){
        return view('auth.account_login');
    }
    
    // 1599408214
    public function auth(Request $request){
        session()->forget('atg_error');
        $data = $request->validate([
            'code' => 'required|exists:school_accounts,code',
            'password' => 'required|string',
        ]);
        $account = SchoolAccount::where('code' , $data['code'])->first();
        // dd(strtolower(decrypt($account->password)));
        if(strtolower(decrypt($account->password)) == strtolower($data['password'])){
            $this->updateAccount($data['code']);
            return redirect()->route('account.dashboard');
        }
        else{
            return redirect()->back()->withErrors(['password' => 'Password is incorrect. please try again!']);
        }
    }

    protected function updateAccount($code){
        $account = SchoolAccount::where('code' , $code)->first();
        if(!empty($account)){
            session()->put('school_account' , encrypt($account));
            return true;
        }
        else{
            session()->forget('school_account');
            session()->forget('atg_error');
            return false;
        }
    }

    protected function getAccount(){
        try{
            return decrypt(session()->get('school_account'));
        }
        catch(Exception $e){
            return null;
        }
    }

    public function isActive(){
        try{
            return !empty($account = $this->getAccount) && $account->status == 1;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function logout(Request $request){
        session()->forget('school_account');
        return redirect()->route('account.login');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Teacher;
use App\Models\Transaction;
use App\Models\PayReceipt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Carbon\Traits\Week;
use \Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index(){
        $user = Auth::user();
        $now = Carbon::now();
        $deps = Transaction::where('type','Deposit');
        $reqs = Transaction::where('type','Request')->where('status','Completed');
        $wths = Transaction::where('type','Withdrawal');
        $Adminwths = Transaction::where('type','Withdrawal')->where('user_id',1)->sum('amount');
        $Devwths = Transaction::where('type','Withdrawal')->where('user_id',2)->sum('amount');

        $dToday = 0;
        $dWeek = 0;
        $dMonth = 0;
        $dAll = $deps->sum('amount');

        $rToday = 0;
        $rWeek = 0;
        $rMonth = 0;
        $rAll = $reqs->sum('amount');

        $wToday = 0;
        $wWeek = 0;
        $wMonth = 0;
        $wAll = $wths->sum('amount');


        foreach($deps->get() as $dep){
            if($now->diffInDays($dep->created_at) == 0){
                $dToday += $dep->amount;
            }
            if($now->diffInWeeks($dep->created_at) == 0){
                $dWeek += $dep->amount;
            }
            if($now->diffInMonths($dep->created_at) == 0){
                $dMonth += $dep->amount;
            }
        }

        foreach($reqs->get() as $dep){
            if($now->diffInDays($dep->created_at) == 0){
                $rToday += $dep->amount;
            }
            if($now->diffInWeeks($dep->created_at) == 0){
                $rWeek += $dep->amount;
            }
            if($now->diffInMonths($dep->created_at) == 0){
                $rMonth += $dep->amount;
            }
        }

        foreach($wths->get() as $dep){
            if($now->diffInDays($dep->created_at) == 0){
                $wToday += $dep->amount;
            }
            if($now->diffInWeeks($dep->created_at) == 0){
                $wWeek += $dep->amount;
            }
            if($now->diffInMonths($dep->created_at) == 0){
                $wMonth += $dep->amount;
            }
        }

        $dep = [
            'today' => $dToday,
            'week' => $dWeek,
            'month' => $dMonth,
            'all' => $dAll,
        ];
        $req = [
            'today' => $rToday,
            'week' => $rWeek,
            'month' => $rMonth,
            'all' => $rAll,
        ];
        $wth = [
            'today' => $wToday,
            'week' => $wWeek,
            'month' => $wMonth,
            'all' => $wAll,
        ];
        $prf = [
            'today' => $rToday*.2,
            'week' => $rWeek*.2,
            'month' => $rMonth*.2,
            'all' => $rAll*.2,
        ];

        $bals = [
            'Abal' => $prf['all']*.85,
            'Awth' => $Adminwths,
            'Dbal' => $prf['all']*.15,
            'Dwth' => $Devwths,
        ];
        
        $reqs = Transaction::where('type','Request');
        $activeReq = $reqs->where('status','Accepted')->count();
        $completeReq = $reqs->where('status','Completed')->count();
        $pendingReq = $reqs->where('status','Pending')->count();
        return view('admin.home',compact('dep','req','wth','prf','bals','user','activeReq','completeReq','pendingReq'));
    }

    public function userinfo($id)
    {
        $user = User::findorfail($id);
        $Myrequests = Transaction::where('type','request')->where('receiver_id',$id)->orderby('created_at','desc')->get();
        $requests = Transaction::where('type','request')->where('user_id',$id)->orderby('created_at','desc')->get();
        $deposits = Transaction::where('type','deposit')->where('user_id',$id)->orderby('created_at','desc')->get();
        $withdrawals = Transaction::where('type','Withdrawal')->where('user_id',$id)->orderby('created_at','desc')->get();
        return view('admin.userinfo',compact('user','requests','deposits','withdrawals','Myrequests'));
    }

    public function users()
    {
        $user = Auth::user();
        $users = User::orderby('name','asc')->get();
        return view('admin.users',compact('users'));
    }
    
    public function update_user(Request $request,$user)
    {
        $user = User::findorfail($user);
        if(!empty($request['amount'])){
            $data['wallet'] = $request['amount'];
        }
        
        if(!empty($request['password'])){
            $data['password'] = Hash::make($request['password']);
        }
        $user->update($data);
        Session::flash('success_msg','User updated sucessfully.');
        return redirect()->back();
    }

    public function requests()
    {
        $users = User::get();
        $requests = Transaction::where('type','Request')->orderby('created_at','desc')->get();
        return view('admin.requests',compact('requests','users'));
    }

    public function deposits()
    {
        $users = User::get();
        $deposits = Transaction::where('type','Deposit')->orderby('created_at','desc')->get();
        return view('admin.deposits',compact('deposits','users'));
    }

    public function withdrawals()
    {
        $users = User::get();
        $withdrawals = Transaction::where('type','Withdrawal')->orderby('created_at','desc')->get();
        return view('admin.withdrawals',compact('withdrawals','users'));
    }
    

    public function receipts()
    {
        $receipts = PayReceipt::orderby('created_at','desc')->get();
        return view('admin.receipts',compact('receipts'));
    }
    
     public function receiptdeposit(Request $request,$id){
        $admin = Auth::user();
        $receipt = PayReceipt::findorfail($id);
        
        
        if($receipt->status == 'Pending'){
            
                $request->validate([
                    'amount' => 'required'
                ]);
                
                $user = User::findorfail($receipt->user_id);
                $amount = $request['amount'];
                
                $data = [
                    'user_id' => $user->id,
                    'uuid' => $this->UUid(),
                    'amount' => $amount,
                    'purpose' => 'Your deposit has been acknowleged and credited to your account! Receipt ID: #'.$id,
                    'type' => 'Deposit',
                    'status' => 'Completed',
                ];
        
                $transaction = Transaction::create($data);
                //update receipt
                $receipt->admin_id = $admin->id;
                $receipt->status = "Approved";
                $receipt->amount = $amount;
                $receipt->save();
                
                if(!empty($transaction->id)){
                    $currbal = $user->wallet;
                    $user->wallet = ($currbal + $amount);
                    $user->save();
        
                    Session::flash('success_msg','Deposit acknowlegded and confirmed!');
                    return redirect()->back();
            }
           
        }
         else{
                Session::flash('error_msg','Deposit already confirmed!');
                return redirect()->back();
            }
        
        Session::flash('error_msg','Operation failed!');
        return redirect()->back();
    }
    
    
    
    public function UUid(){
        $id = rand(100000000,9999999999);
        $check = Transaction::where('uuid',$id)->count();
        if($check < 1){
            return $id;
        }
        else{
            $this->UUid();
        }
    }
    
    public function manualdeposit(Request $request){
        $request->validate([
            'user_id' => 'required',
            'amount' => 'required'
        ]);
        $admin = Auth::user();
        $user = User::findorfail($request->user_id);
        $amount = $request['amount'];
        
        
        $data = [
            'user_id' => $user->id,
            'uuid' => $this->UUid(),
            'amount' => $amount,
            'purpose' => 'Your deposit has been acknowleged and credited to your account!',
            'type' => 'Deposit',
            'status' => 'Completed',
        ];
        
        $transaction = Transaction::create($data);

                if(!empty($transaction->id)){
                    $currbal = $user->wallet;
                    $user->wallet = ($currbal + $amount);
                    $user->save();
                    
                    $receipt['admin_id'] = $admin->id;
                    $receipt['user_id'] = $user->id;
                    $receipt['type'] = 'Manual';
                    $receipt['status'] = 'Approved';
                    $receipt['amount'] = $amount;
                    
                    $receipt = PayReceipt::create($receipt);
        
                    Session::flash('success_msg','Deposit acknowlegded and confirmed!');
                    return redirect()->back();
            }
        
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CouponController extends Controller
{
    public function index()
    {
        $agents = Agent::where('status',1)->get();
        $coupons = Coupon::orderby('created_at','desc')->get();
        return view('admin.coupons',compact('agents', 'coupons'));
    }

    private function couponCode(){
        $code = rand(1000000000,9999999999);
        $check = Coupon::where('code',$code)->count();
        if($check > 0){
            return $this->couponCode();
        }
        return $code;
    }

    public function store(Request $request){
        $data = $request->validate([
            'agent_id' => 'required|integer',
            'amount' => 'required|integer',
            'quantity' => 'required|integer',
        ]);
        $batchNo = time();
        $times = ($data['quantity'] * 1);
        for($i = 0;$i < $times; $i++){
            Coupon::create([
                'agent_id' => $data['agent_id'],
                'amount' => $data['amount'],
                'batch_no' => $batchNo,
                'code' => $this->couponCode(),
            ]);
        }
        Session::flash('notify_msg','Coupons added successfully!');
        return redirect()->back();
    }

    public function destroy(Request $request,$id){

        $coupon = Coupon::findorfail($id);
        $coupon->delete();
        Session::flash('notify_msg','Coupons deleted successfully!');
        return redirect()->back();
    }
}

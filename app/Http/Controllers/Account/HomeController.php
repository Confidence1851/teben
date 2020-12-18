<?php

namespace App\Http\Controllers\Account;

use App\Helpers\VideoStream;
use App\Models\Media;
use App\Models\SchoolAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    
    public function dashboard(){
        $account = $this->getAccount();
        if(empty($account)){
            return redirect()->route('account.login');
        }
        $this->updateAccount($account->code);

        $status = false;
        if($account->status == 1){
            $status = true;
        }
        else{
            session()->flash('error' , 'Your account in inactive!  Pay to activate your account');
        }

        return view('account.dashboard' , compact('account' , 'status'));
    }

   
   

    public function atg_callback(Request $request){
        $user = auth()->user();
        $reference = $request->reference;
//         if(false){
//             $curl = curl_init();
//             curl_setopt_array($curl, array(
//                 CURLOPT_URL => "https://aimtoget.com/payment/verify/".$reference,
//                 CURLOPT_RETURNTRANSFER => true,
//                 CURLOPT_ENCODING => "",
//                 CURLOPT_TIMEOUT => 30000,
//                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                 CURLOPT_CUSTOMREQUEST => "POST",
//                 // CURLOPT_HTTPHEADER => array(
//                 // 	// Set Here Your Requesred Headers

//                 // ),
//             ));

//             $response = curl_exec($curl);
//             $err = curl_error($curl);
//             curl_close($curl);
//         }
//         if (false) {
//             echo "cURL Error #:" . $err;
//         } else {
//             $result = json_decode($response);

//             if(empty($result)){
//                 session()->flash('error_msg','Error occurred! Couldnt validate reference No. #'.$reference);
//                 session()->put('atg_error' , 'Error occurred! Couldnt validate reference No. #'.$reference. ' Call the admin with this reference number to manually verify your payment!');
//                 return response()->json();
//             }

            $recharge = [
                'user_id' => $user->id ?? null,
                'uuid' => $reference,
                'amount' => 0,//$result->data->amount,
                'purpose' => 'Your airtime recharge was successful!',
                'type' => 'Deposit',
                'status' => 'Completed',
            ];
            Transaction::create($recharge);

            $raw = decrypt(session()->get('school_account'));
            $account = SchoolAccount::findorfail($raw->id);
            $account->status = 1;
            $account->save();
            session()->put('school_account' , encrypt($account));
            session()->flash('success_msg','Recharge Successful!');
            session()->forget('atg_error');
            return response()->json();
//         }
    }

}

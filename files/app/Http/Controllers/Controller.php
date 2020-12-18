<?php

namespace App\Http\Controllers;


use App\Models\Notification;
use App\Models\Teacher;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Subject;
use App\Models\PayReceipt;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function UUid(){
        $id = rand(10000000,999999999);
        $check = User::where('uuid',$id)->count();
        if($check < 1){
            return $id;
        }
        else{
            $this->UUid();
        }
    }
    
    public function subjects(){
        return $data = [
            'Basic Science',
            'Basic Technology',
            'Biology',
            'Book Keeping/Account',
            'Business Studies/Office Practice',
            'Chemistry',
            'Commerce',
            'Computer',
            'Creative/Fine Arts',
            'Economics',
            'English language',
            'Fine Art',
            'Further Mathematics',
            'Geography',
            'Health Science',
            'I.P.C',
            'Islamic Studies',
            'Literature in English',
            'Mathematics',
            'Physical Health Education',
            'Physics',
            'Social Studies',
            'Technical Drawing',
            'Quantitative/Verbal Reasoning',
        ];
    }

    public function admin(){
        $admin = User::where('email','admin@tebentutors.com')->first();
        return $admin;
    }

    public function developer(){
        $dev = User::where('email','ugoloconfidence@gmail.com')->first();
        return $dev;
    }
    
    public function checkRequest(){
        $now = new Carbon();
        $now = Carbon::parse($now);
        
        $allrequests = Transaction::where('type','Request')->orderby('created_at','desc')->get();
        foreach($allrequests as $request){
           
            $schedule = Carbon::parse($request->schedule);
            $created = Carbon::parse($request->created_at);
           
            // dump($now);
            // dump($schedule);
            // dd($now->diffInSeconds($schedule,false));
            
            if($request->status == "Pending"){
                
                if($created->diffInHours($now,false) > 24){
                    $user = User::find($request->user_id);
                    // dd($user);
                    $msg = " Request automatically cancelled.Money refunded!";
                    $type = "Refund";
                    $this->refundParent($user,$request, $msg , $type);
                    
                    $request->purpose = $msg;
                    $request->status = $type;
                    $request->save();
                }
            }
            
            elseif($request->status == "Accepted"){
                if($now->diffInSeconds($schedule,false) < 1){
                    $teacher = User::find($request->receiver_id);
                    // dd($teacher);
                    $msg = " Request completed successfully!";
                    $type = "Completed";
                    // dd('stop');
                    $this->completeRequest($teacher,$request, $msg , $type);
                    
                    $request->purpose = $msg;
                    $request->status = $type;
                    $request->save();
                }
            }
            
        }
        return ;
    }
    
    //refund or cancel or decline
    public function refundParent($user,$transaction , $msg ,$type){
        
            //send notification to user
            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->reference_id = $transaction->id;
            $notification->message = $msg;
            $notification->type = $type;
            $notification->save();
            
            $user->wallet = $user->wallet + $transaction->amount;
            $user->save();
            
            return ;
    }
    
    
    //close transaction and pay teacher
    public function completeRequest($user,$transaction , $msg ,$type){
        
            //send notification to user
            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->reference_id = $transaction->id;
            $notification->message = $msg;
            $notification->type = $type;
            $notification->save();
            
            $money =  ($transaction->amount*.8) ;
            $user->wallet = $user->wallet + $money;
            $user->teacher->jobs =  $user->teacher->jobs + 1;
            $user->save();
            
             $data = [
            'user_id' => $user->id,
            'uuid' => $this->UUid(),
            'amount' => $money,
            'purpose' => 'You have been credited for a completed task',
            'type' => 'Credit',
            'status' => $type,
        ];

        $transaction = Transaction::create($data);
        
        return ;
    }
    
    
    public static function states(){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://locationsng-api.herokuapp.com/api/v1/states",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
             CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_HTTPHEADER => array(
            // 	// Set Here Your Requesred Headers
                
            // ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response);
            $returnData = $result;
            // foreach($returnData as $r){
            //     dump($r->name);
            // }
            // dd('done');
            
            return $returnData ;
        }

    }
    
    
    public function lgas($state){
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://locationsng-api.herokuapp.com/api/v1/states/".$state."/details",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
             CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_HTTPHEADER => array(
            // 	// Set Here Your Requesred Headers
                
            // ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response);
            $returnData = $result;
            // foreach($returnData as $r){
            //     dump($r->name);
            // }
            // dd('done');
            
            return $returnData ;
        }

    }
    
    
}













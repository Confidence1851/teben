<?php

namespace App\Http\Controllers;


use App\Notification;
use App\Teacher;
use App\Transaction;
use App\User;
use App\Subject;
use App\PayReceipt;
use App\Traits\Constants;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests , Constants;

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


    


}













<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Comment;
use App\Notification;
use App\Teacher;
use App\Transaction;
use App\User;
use App\Subject;
use App\PayReceipt;
use Carbon\Carbon;
use App\Invest;
use App\Coupon;
use App\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Storage;
use File;
use Response;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\SchoolAccount;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\DB;

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
    }



    public function mynotifications($last = null){
        $user = Auth::user();
        if(is_null($last)){
            $nots = Notification::where('user_id',$user->id)->orderby('id','desc')->paginate(10);
        }
        else{
            $nots = Notification::where('user_id',$user->id)->where('id','<',($last+1))->orderby('id','desc')->paginate(5);
        }
        $data = collect();

        foreach($nots as $not){

            $startTime = Carbon::parse($not->created_at);
            $finishTime = Carbon::now();

            $time = $startTime->diffForHumans($finishTime , true);

            $data->put($not->id,['msg'=> $not->message,'type' => $not->type, 'status' => $not->read_status, 'ref' => $not->reference_id, 'time' => $time.' ago']);
        }
        return response()->json(array($data));
    }



    public function quicktutors()
    {
        $subjects = Subject::orderby('name','asc')->get();
        return view('dashboard.tutors',compact('subjects'));
    }

    public function getTutors(Request $request){
        $user = Auth::user();
        $list = collect();
        $teachers = Teacher::where('user_id','!=',$user->id)->where('status',1)->orderby('rating','desc')->get(); //->toArray()
        foreach($teachers as $teacher){
            $age = abs(date("Y") - $teacher->dob);   //Carbon::parse($teacher->dob)->diffInYears(now());
           if($teacher->major == $request['subject'] || $teacher->sub1 == $request['subject'] || $teacher->sub2 == $request['subject'] ){
                $list->put($teacher->id , [$teacher->user->name, $teacher->user->avatar, $age, $teacher->qualification, $teacher->yrs_experience,[$teacher->user->town.' , '.$teacher->user->lga.' , '.$teacher->user->state],$teacher->language,$teacher->jobs,$teacher->user->uuid,$teacher->user->id]);
            }

        }
        // dd($list);
        // $list = $list->toArray();
        return response()->json(array($list));
    }

    public function uploadAvatar(Request $request){
        $user = Auth::user();

        if(!empty($user->avatar)){
            deleteFileFromPrivateStorage($user->avatarPath());
            $user->update(["avatar" => null]);
        }

        $image = $request->file('image');
        $filename = putFileInPrivateStorage($image , $this->userAvatarImagePath);

        $user->avatar = $filename;
        $user->save();

        $data=[$filename];

        return response()->json(array($data));
    }

    public function completeProfile(Request $request){
        $user = Auth::user();
        $data = $request->validate([
            'phone' => 'required',
            'gender' => 'required',
            'marital_status' => 'required',
            'state' => 'required',
            'address' => 'required',
            'country' => 'required',
            'lga' => 'required',
            'town' => 'required',
        ]);


        $user->update($data);

        return redirect('/home');

    }

    public function createbank(Request $request){
        $user = Auth::user();
        $data = $request->validate([
            'bank_name' =>  'required',
            'account_name' =>  'required',
            'account_no' =>  'required|min:10|max:10',
        ]);
        $thisbank = Bank::where('user_id',$user->id)->count();
        if($thisbank > 0){
            Session::flash('error_msg','You already have a bank account added!');
            return redirect()->back();
        }
        $thisacct = Bank::where('account_no',$data['account_no'])->count();
        if($thisacct > 0){
            Session::flash('error_msg','Account number already exists!');
            return redirect()->back();
        }

        $data['user_id'] = $user->id;
        $bank = Bank::create($data);
        return redirect('/home');
    }

    public function updateProfile(Request $request){
        $data = $request->validate([
            'phone' => 'required',
            'address' => 'required',
            'marital_status' => 'required',
            'state' => 'required',
            'address' => 'required',
            'country' => 'required',
            'lga' => 'required',
            'town' => 'required',
        ]);

        $user = Auth::user();
        if($request['image'] != ""){

            if(!empty($user->avatar)){
                deleteFileFromPrivateStorage($user->avatarPath());
                $user->update(["avatar" => null]);
            }

            $image = $request->file('image');
            $filename = putFileInPrivateStorage($image , $this->userAvatarImagePath);

            $data['avatar'] = $filename;
        }

        $user->update($data);

        Session::flash('success_msg','Profile updated successfully!');

        return redirect()->back();
    }


    public function homeschooling(){
        return view('dashboard.homeschooling');
    }

    public function transactions(){
        $user = Auth::user();
        $transactions = Transaction::where('user_id',$user->id)->orderby('created_at','desc')->get();
        return view('dashboard.transactions',compact('transactions'));
    }

    // public function myrequests(){
    //     $user = Auth::user();
    //     $requests = Transaction::where('user_id',$user->id)->where('type','Request')->orderby('created_at','desc')->get();
    //     return view('dashboard.myrequests',compact('requests'));
    // }

    public function lessonrequests(){
        $user = Auth::user();
        $requests = Transaction::where('type','Request')->where('user_id',$user->id)->orWhere('receiver_id',$user->id)->orderby('created_at','desc')->get();
        return view('dashboard.myrequests',compact('requests'));
    }

    public function uploadreceipt(Request $request){
        // $user = Auth::User();
        // $data = $request->validate([
        //     'image' => 'required'
        // ]);
        // $image = $request->file('image');
        // $filename = putFileInPrivateStorage($image , $this->receiptImagePath);

        // $data['user_id'] = $user->id;
        // $data['image'] = $filename;
        // $data['type'] = 'Uploaded';

        // $receipt = PayReceipt::create($data);
        // Session::flash('success_msg','Deposit would be processed soon!');
        return redirect()->back();
    }

    public function couponRecharge(Request $request){
        DB::beginTransaction();
        try{
            $data = $request->validate([
                'code' => 'required|string',
                'school_account_id' => 'nullable|exists:school_accounts,id',
            ]);

            $coupon = Coupon::where('code',$data['code'])->first();
            // Check if code is valid
            if(empty($coupon)){
                Session::flash('error_msg','Coupon is invalid!');
                return redirect()->back();
            }

            if(empty($request['school_account_id'])){
                $user = Auth::user();
                if(!empty($coupon->user_id)){
                    if($coupon->user_id == $user->id){
                        Session::flash('error_msg','Coupon has been used by you!');
                        return redirect()->back();
                    }
                    else{
                        Session::flash('error_msg','Sorry, coupon has been used!');
                        return redirect()->back();
                    }
                }
                $user->wallet+= $coupon->amount;
                $user->save();
                $coupon->user_id = $user->id;
            }
            else{
                $account = SchoolAccount::findorfail($request['school_account_id']);
                if($coupon->amount < $account->amount){
                    Session::flash('error_msg','Coupon value is less than required amount!');
                    return redirect()->back();
                }
                if(!empty($coupon->school_account_id)){
                    if($coupon->school_account_id == $account->id){
                        Session::flash('error_msg','Coupon has been used by you!');
                        return redirect()->back();
                    }
                    else{
                        Session::flash('error_msg','Sorry, coupon has been used!');
                        return redirect()->back();
                    }
                }

                $account->status = 1;
                $account->save();
                $coupon->school_account_id = $account->id;
                session()->put('school_account' , encrypt($account));
            }

            $coupon->save();

            $recharge = [
                'user_id' => $user->id ?? null,
                'school_account_id' => $account->id ?? null,
                'uuid' => $this->UUid(),
                'amount' => $coupon->amount,
                'purpose' => 'Your recharge NGN'. $coupon->amount .' was successful!Coupon Code: #'.$coupon->code,
                'type' => 'Deposit',
                'status' => 'Completed',
            ];

            Transaction::create($recharge);

            Session::flash('success_msg','Recharge Successful!');
            DB::commit();
            return redirect()->back();
        }
        catch(Exception $e){
            DB::rollback();
            Session::flash('error_msg', $e->getMessage());
            return redirect()->back();
        }
    }

    public function deposit(Request $request){
        $user = Auth::user();
        $amount = $request['amount'];
        // if($amount < 500){
        //     Session::flash('error_msg','Deposit amount is below NGN 500!');
        //     return redirect()->back();
        // }

        $data = [
            'user_id' => $user->id,
            'uuid' => $this->UUid(),
            'amount' => $amount,
            'purpose' => 'Your deposit has been acknowleged and credited to your account! Reference Number: '.$request['ref'],
            'type' => 'Deposit',
            'status' => 'Completed',
        ];

        $transaction = Transaction::create($data);

        if(!empty($transaction->id)){
            $currbal = $user->wallet;
            $user->wallet = ($currbal + $amount);
            $user->save();

            Session::flash('success_msg','Deposit acknowlegded and confirmed!');
            return redirect()->back();
        }

        Session::flash('error_msg','Operation failed!');
        return redirect()->back();
    }

    public function withdraw(){
        $user = Auth::user();
        // if($user->wallet < 1000){
        //     Session ::flash('error_msg','Withdraw amount is below NGN 1000!');
        //     return redirect()->back();
        // }

        $data = [
            'user_id' => $user->id,
            'uuid' => $this->UUid(),
            'amount' => $user->wallet,
            'purpose' => 'Your withdrawal has been acknowleged! You would be credited soon.',
            'type' => 'Withdrawal',
            'status' => 'Processing',
        ];

        $bName = explode(',',$user->bank->bank_name);

        // Make Post Fields Array
        $wthData = [
               "type" => "nuban",
               "name" => "Zombie",
               "description" => "Zombier",
               "account_number" => $user->bank->account_no,
               "bank_code" => $bName[0],
               "currency" => "NGN",
               "description" => "You placed a withdrawal",
               "name" => $user->name,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transferrecipient",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($wthData),
            CURLOPT_HTTPHEADER => array(
            	// Set here requred headers
                "Authorization: Bearer ",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response);
            $returnData = $result->data;
            dd($returnData);
        }

        // $transaction = Transaction::create($data);

        // if(!empty($transaction->id)){
        //     $user->wallet = 0;
        //     $user->save();



        //     Session::flash('success_msg','Withdrawal acknowlegded and confirmed!');
        //     return redirect()->back();
        // }

        // Session::flash('error_msg','Operation failed!');
        // return redirect()->back();
    }


    public function transReceipts(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transferrecipient",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            	// Set Here Your Requesred Headers
                "Authorization: Bearer ",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response);
            $returnData = $result->data;
            dd($returnData[0]);
        }

    }




    public function requestTeacher(Request $request){

        $user = Auth::user();

        $request->validate([
            'time' => 'required',
            'date' => 'required',
        ]);

        $data = $request->validate([
            'amount' => 'required',
            'receiver_id' => 'required',
            'subject' => 'required',
            'duration' => 'required',
            'curriculum' => 'required',

        ]);

        $data['user_id'] = $user->id;
        $data['uuid'] = $this->UUid();
        $data['purpose'] = $user->name.' requested a lesson session';
        $data['type'] = 'Request';
        $data['status'] = 'Pending';
        $data['schedule'] = $request['date'].' '.$request['time'];

        // dd($data);


        $wallet = $user->wallet;

        if($wallet >= $data['amount']){
            $teacher = User::find($data['receiver_id']);

            $transaction = Transaction::create($data);
            $user->wallet = ($wallet - $data['amount']);
            $user->save();


            //send notification to teacher
            $notification = new Notification();
            $notification->user_id = $teacher->id;
            $notification->reference_id = $transaction->id;
            $notification->message = "New lesson request!";
            $notification->type = "Request";
            $notification->save();

            //send notification to admin
            $notification = new Notification();
            $notification->user_id = $this->admin()->id;
            $notification->reference_id = $transaction->id;
            $notification->message = "New lesson request! Check for Reference #".$transaction->uuid;
            $notification->type = "Request";
            $notification->save();

            Session::flash('success_msg','A notification has been sent to the teacher!');
            return redirect('/home');
        }
        else{
            Session::flash('error_msg','Insuffcient funds!');
            return redirect()->back();
        }
        Session::flash('error_msg','Operation failed!');
        return redirect()->back();
    }


    public function tranResponse(Request $request, $id){
        $data = $request->validate([
            'option' => 'required',
        ]);
        $opt = $data['option'];
        $tran = Transaction::find($id);
        $parent = $tran->user;
        $teacher = User::find($tran->receiver_id);

        if($opt == 'Accepted'){    //Request was accepted
            $tran->status = $opt;
            $tran->save();

            //send notification to parent
            $notification = new Notification();
            $notification->user_id = $parent->id;
            $notification->reference_id = $tran->id;
            $notification->message = "Request accepted!";
            $notification->type = $opt;
            $notification->save();

            Session::flash('success_msg','Accepted!');
            return redirect()->back();
        }

        if($opt == 'Declined'){    //Request was declined
            $tran->status = $opt;
            $tran->save();

            $msg = " Request was declined!";
            $type = $opt;
            $this->refundParent($parent,$tran, $msg , $type);

            // send email to parent

            Session::flash('success_msg','Declined!');
            return redirect()->back();
        }

        if($opt == 'Cancelled'){    //Request was cancelled
            $tran->status = $opt;
            $tran->save();

            $msg = "Request has been cancelled!";
            $type = $opt;
            $this->refundParent($parent,$tran, $msg , $type);

            // Send emails

            Session::flash('success_msg','Cancelled!');
            return redirect()->back();
        }

        Session::flash('error_msg','Operation failed!');
        return redirect()->back();
    }

    public function tranComment(Request $request, $id){
        $data = $request->validate([
            'type' => 'required',
            'message' => 'required',
        ]);
        $tran = Transaction::find($id);
        $data['transaction_id'] = $tran->id;
        $data['user_id'] = Auth::user()->id;

        $comment = Comment::create($data);

        if($data['type'] == 'Report'){
            //send notification to admin
            $notification = new Notification();
            $notification->user_id = $this->admin()->id;
            $notification->reference_id = $tran->id;
            $notification->message = "A transaction has been reported!";
            $notification->type = 'Report';
            $notification->save();
        }

        Session::flash('success_msg','Submitted!');
        return redirect()->back();
    }


    public function mail(){

       $name = 'Krunal';
       Mail::to('ugoloconfidence@hotmail.com')->send(new TestMail($name));

       return 'Email was sent';
    }

    public function test(){
        return $this->checkRequest();
    }

    public function verifybank(Request $request){
        // dd($request);
        $data = $request->validate([
            'bank_name' => 'required',
            'account_no' => 'required',
        ]);

        // dd($data);

        $bank_code = $data['bank_name'];
        $account_no = $data['account_no']; //2119206517;//

        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $header = array('Authorization'=> 'Bearer ');
        $link = 'account_number='.$account_no.'&bank_code='.$bank_code ;
        $request = $client->get("https://api.paystack.co/bank/resolve?".$link , array('headers' => $header ) );
        $return = json_decode($request->getBody());

        if($return->status == true){
            return response()->json(['status'=>true,'name'=>$return->data->account_name]);
        }
        if($return->status == false){
            return response()->json(['status'=>false,'name'=>'Account not found!']);
        }
    }

    public function getnotify(){
        $last = 0;
        $nots = [
            1,2,3,4,46,5,8,0,7,1900,900
        ];
        foreach($nots as $d){
            if($d > $last){
                $last = $d;
            }
        }
        return response()->json([$last]);
    }

    public function barcode()
    {
        // $d = new DNS2D();
        // $d->setStorPath(__DIR__."/cache/");
        // echo $d->getBarcodeHTML("hi", "QRCODE");
        \Storage::disk('public')->put('test.png',base64_decode(DNS2D::getBarcodePNG("70000", "QRCODE")));
        return view('dashboard.barcode');
    }

    public function myinfo(){
        $user = Auth::user();

        return view('dashboard.myinfo',compact('user'));
    }

    public function makeInvestment(Request $request){
        $data = $request->validate([
            'amount' => 'required',
            'duration' => 'required',
        ]);
        $user = Auth::user();
        $period = $data['duration'];
        $amt = $data['amount'];

        if($period == 6){
            switch ($amt){
                case 20000: $perc = 14; break;
                case 50000: $perc = 22; break;
                case 100000: $perc = 25; break;
                case 200000: $perc = 28; break;
                case 500000: $perc = 31; break;
                case 1000000: $perc = 32; break;
            }
        }
        if($period == 12){
            switch ($amt){
                case 20000: $perc = 17; break;
                case 50000: $perc = 25; break;
                case 100000: $perc = 28; break;
                case 200000: $perc = 31; break;
                case 500000: $perc = 34; break;
                case 1000000: $perc = 35; break;
            }
        }
        $profit = (($amt * $perc) / 100);
        $data['user_id'] = $user->id;
        $data['profit'] = $profit;
        $data['reference'] = $this->uuid();
        $data['percent'] = $perc;
        $data['status'] = "Pending";

        $user->wallet-=$amt;
        $user->save();

        $invest = Invest::create($data);

        $tran = Transaction::create([
            'user_id' => $user->id,
            'uuid' => $this->UUid(),
            'purpose' => 'You invested the sum of NGN'.$amt ,
            'type' => 'Debit',
            'amount' => $amt,
            'status' => 'Completed',
        ]);

        //send notification to user
        $notification = new Notification();
        $notification->user_id = $user->id;
        $notification->reference_id = $invest->id;
        $notification->message = "Your investment request has been submitted!";
        $notification->type = 'Investment';
        $notification->save();

        //send notification to admin
        $notification = new Notification();
        $notification->user_id = $this->admin()->id;
        $notification->reference_id = $invest->id;
        $notification->message = "An investment request has been submitted. Kindly review it!";
        $notification->type = 'Investment';
        $notification->save();

        Session::flash('success_msg','Submitted, kindly wait for confirmation!');
        return redirect()->back();
    }


    public function available_books()
    {
        $user = Auth::user();
        $mediaList = Media::where('status','Visible')->orderby('title','asc')->get();
        $medias = [];
        foreach($mediaList as $media){
           $medias.= $this->mediaTemplate($media);
        }
        return view('dashboard.available_books',compact('user','medias'));
    }

    function mediaPath(){
        return 'media/attachments/';
    }

    protected function mediaTemplate($media){
       return '<div class="card-header row mb-3">
            <div class="col-md-4 text-center">
                <img src="'.asset('public/media_cover_images'.'/'.$media->image) .'" alt="Cover Image" width="100%" height="100px"/>
            </div>
            <div class="col-md-8 mt-2 mt-md-3">
                <div class="h4"><b>'.$media->title.'</b></div>
                <div class="mb-2">
                    <b>Media Type:</b> '.$media->attachment_type.'
                </div>
                <div class="mb-2">
                    <b>File Size:</b> '.$media->size.'
                </div>
                <div class="mb-2">
                    <b>Level:</b> '.$media->level.'
                </div>
                <div class="mb-2">
                    <b>Subject:</b> '.$media->subject.'
                </div>
                <div class="mb-3">
                    <b>Price:</b> NGN '.$media->price.'
                </div>
                <div class="">
                    <form action="'. route('user_download_attachment') .'" method="post" onsubmit="return confirm(\'Downloading may cost you money! Are you sure you want to download this item?\');"> '.csrf_field().'
                        <input type="hidden" name="media_id" value="'.$media->id.'" required>
                        <input type="hidden" name="name" value="'.$media->title.'" required>
                        <button type="submit" class="btn btn-sm btn-primary" >Download</button>
                    </form>
                </div>

            </div>
        </div>';
    }

    public function downloadAttachment(Request $request){
        // dd($request->all());
        $data = $request->validate([
            'media_id' => 'required',
            'name' => 'required'
        ]);

        // dd($data);

        $media = Media::findorfail($data['media_id']);

        $name = $data['name'];
        $filename = $media->attachment;
        $amt = $media->price;

        $user = Auth::user();

        if($user->wallet >= $amt){


            $path = $this->mediaPath().$filename;
            $exists = Storage::disk('local')->exists($path);
            if($exists){

                $user->wallet-=$amt;
                $user->save();


                $tran = Transaction::create([
                    'user_id' => $user->id,
                    'uuid' => $this->UUid(),
                    'purpose' => 'You downloaded an item for the sum of NGN'.$amt ,
                    'type' => 'Debit',
                    'amount' => $amt,
                    'status' => 'Completed',
                ]);

                //send notification to user
                $notification = new Notification();
                $notification->user_id = $user->id;
                $notification->reference_id = $media->id;
                $notification->message = "Your download is complete!";
                $notification->type = 'Download';
                $notification->save();


                $type = Storage::mimeType($path);
                $ext = explode('.',$filename)[1];
                // dd($ext);
                $headers = [
                    'Content-Type' => $type,
                ];

                Session::flash('success_msg','Downloading in progress...');
                return Storage::download($path,$name.'.'.$ext,$headers);
            }

            Session::flash('error_msg','Download unsuccessful!');
            return back();

        }
        Session::flash('error_msg','Insufficient funds!');
        return back();
    }

}

// end

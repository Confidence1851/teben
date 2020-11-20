<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Klass;
use App\Media;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
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


    public function index(Request $request , $type = "")
    {
        $builder = Media::where('status','Visible')->where("attachment_type" , $type == "books" ? "Document" : "Video")->orderby('title','asc');

        if(!empty($key = $request['keyword'])){
            $builder = $builder->where('title' , 'like' , "%$key%")->orWhereHas('subject' , function($query) use ($key){
                $query->where('name' , 'like' , "%$key%");
            });
        }
        if(!empty($key = $request['class'])){
            $builder = $builder->where('klass_id' , 'like' , "%$key%");
        }
        if(!empty($key = $request['term'])){
            $builder = $builder->where('term' , 'like' , "%$key%");
        }

        $user = auth()->user();
        $media = $builder->paginate(20);
        $title = ucfirst($type);
        $url = route("user.media.index" , $type);
        $classes = Klass::orderby("name")->get();
        $terms = getTerms();
        $requestData = [
            "keyword" => $request['keyword'],
            "class" => $request['class'],
            "term" => $request['term'],
        ];
        return view('user.media.index',compact('user','media' , 'title' , 'url' , 'requestData' , 'classes' , 'terms'));
    }

 
    public function download(Request $request){
        $data = $request->validate([
            'media_id' => 'required',
        ]);

        $media = Media::findorfail($data['media_id']);

        $name = $media->title;
        $filename = $media->getAttachment();
        $amt = $media->price;

        $user = auth()->user();

        if($user->wallet >= $amt){
            $exists = Storage::disk('local')->exists($filename);
            if($exists){
                $user->wallet-=$amt;
                $user->save();


                $tran = Transaction::create([
                    'user_id' => $user->id,
                    'uuid' => getRandomToken(6),
                    'purpose' => 'You downloaded an item for the sum of NGN'.$amt ,
                    'type' => 'Debit',
                    'amount' => $amt,
                    'status' => 'Completed',
                    'media_id' => $media->id,
                ]);

                //send notification to user
                // $notification = new Notification();
                // $notification->user_id = $user->id;
                // $notification->reference_id = $media->id;
                // $notification->message = "Your download is complete!";
                // $notification->type = 'Download';
                // $notification->save();



                session()->flash('success_msg','Downloading in progress...');
                return downloadFileFromPrivateStorage($filename , $name);
            }

            session()->flash('error_msg','Download unsuccessful!');
            return back();

        }
        session()->flash('error_msg','Insufficient funds!');
        return back();
    }
}

// end

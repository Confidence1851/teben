<?php

namespace App\Http\Controllers\Account;

use App\Helpers\VideoStream;
use App\Media;
use App\SchoolAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends BaseController
{


    public function index(Request $request , $type = "")
    {
        $account = $this->getAccount();
        $builder = Media::where('status','Visible')
                        ->where("attachment_type" , $type == "books" ? "Document" : "Video")
                        ->where('klass_id' , $account->klass_id)
                        ->where('term' , $account->term)
                        ->orderby('title','asc');


        if(!empty($key = $request['keyword'])){
            $builder = $builder->where('title' , 'like' , "%$key%")->orWhereHas('subject' , function($query) use ($key){
                $query->where('name' , 'like' , "%$key%");
            });
        }
        // if(!empty($key = $request['class'])){
        //     $builder = $builder->where('klass_id' , 'like' , "%$key%");
        // }
        // if(!empty($key = $request['term'])){
        //     $builder = $builder->where('term' , 'like' , "%$key%");
        // }

        $media = $builder->paginate(20);
        $title = ucfirst($type);
        $url = route("media_collection.index" , $type);
        $terms = getTerms();
        $requestData = [
            "keyword" => $request['keyword'],
            "class" => $request['class'],
            "term" => $request['term'],
        ];
        return view('account.media.index',compact('media' , 'title' , 'url' , 'requestData' ));
    }

    
    public function download(Request $request){
        $data = $request->validate([
            'media_id' => 'required',
        ]);


        $media = Media::findorfail($data['media_id']);

        $name = $media->title;
        $filename = $media->getAttachment();
        $amt = $media->price;

        $account = $this->getAccount();

        if(!empty($account) && $account->available > 0){
            $exists = Storage::disk('local')->exists($filename);
            if($exists){
                $account->available-1;
                $account->save();
                $this->updateAccount($account->code);
                session()->flash('success_msg','Downloading in progress...');
                return downloadFileFromPrivateStorage($filename , $name);
            }

            session()->flash('error_msg','Download unsuccessful!');
            return back();

        }
        session()->flash('error_msg','Insufficient funds!');
        return back();
    }

    public function watchVideoAttachment($filename){
        $stream = new VideoStream(decrypt($filename));
        return $stream->start();
    }
}

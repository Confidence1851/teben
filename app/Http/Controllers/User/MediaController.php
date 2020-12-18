<?php

namespace App\Http\Controllers\User;

use App\Helpers\AppConstants;
use App\Http\Controllers\Controller;
use App\Klass;
use App\Media;
use App\Traits\Transaction;
use App\Traits\Wallet;
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


    public function index(Request $request, $type = "")
    {
        $builder = Media::where('status', 'Visible')->where("attachment_type", $type == "books" ? "Document" : "Video")->orderby('title', 'asc');

        if (!empty($key = $request['keyword'])) {
            $builder = $builder->where('title', 'like', "%$key%")->orWhereHas('subject', function ($query) use ($key) {
                $query->where('name', 'like', "%$key%");
            });
        }
        if (!empty($key = $request['class'])) {
            $builder = $builder->where('klass_id', 'like', "%$key%");
        }
        if (!empty($key = $request['term'])) {
            $builder = $builder->where('term', 'like', "%$key%");
        }

        $user = auth()->user();
        $media = $builder->paginate(30);
        $title = ucfirst($type);
        $url = route("user.media.index", $type);
        $classes = Klass::orderby("name")->get();
        $terms = getTerms();
        $requestData = [
            "keyword" => $request['keyword'],
            "class" => $request['class'],
            "term" => $request['term'],
        ];
        return view('web.pages.media.index', compact('user', 'media', 'title', 'url', 'requestData', 'classes', 'terms'));
    }


    public function details(Request $request)
    {
        return view('web.pages.media.info');
    }


    public function download(Request $request)
    {
        $data = $request->validate([
            'media_id' => 'required',
        ]);

        $media = Media::findorfail($data['media_id']);

        $name = $media->title;
        $filename = $media->getAttachment();
        $amount = $media->price;

        $user = auth()->user();

        $exists = Storage::disk('local')->exists($filename);
        if ($exists) {
            $charge = Wallet::debit(
                $user->id,
                $amount,
                'You downloaded an item for the sum of NGN' . $amount,
                AppConstants::MEDIA_DOWNLOAD,
                $media->id
            );

            if(!$charge["success"]){
                return back()->with('error_msg', $charge["msg"]);
            }

            session()->flash('success_msg', 'Downloading in progress...');
            return downloadFileFromPrivateStorage($filename, $name);
        }

        session()->flash('error_msg', 'Media file seems to be missing!');
        return back();
    }
}

// end

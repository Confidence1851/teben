<?php

namespace App\Http\Controllers;

use App\Helpers\VideoStream;
use App\Models\Klass;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Media;
use App\Models\Subject;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        $medias = Media::orderby('title','asc')->paginate(50);
        $subjects = Subject::orderby('name','asc')->get();
        $levels = getLevels();
        $klasses = Klass::get();
        $terms = getTerms();
        return view('admin.media.index',compact('medias','subjects' ,'levels' , 'klasses' , 'terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = $this->validateData($request , 'required');

        $cover_filename = $this->saveCoverImage($request);

        $attachment = $this->saveAttachment($request);

        $size = bytesToHuman(File::size($attachment['attachment']));
        $attachType = getFileType($attachment['type']);

       $data['image'] = $cover_filename;
       $data['attachment'] = $attachment['filename'];
       $data['attachment_type'] = $attachType;
       $data['size'] = $size;
       Media::create($data);

       return redirect()->route('media.index')->withSuccess(__('Media successfully added.'));
    }

    public function saveAttachment(Request $request){
        $attachment = $request->file('attachment');
        $type = $attachment->getClientOriginalExtension();
        $filename = putFileInPrivateStorage($attachment , $this->mediaAttachmentsFilePath);

        return [
            'attachment' => $attachment,
            'type' => $type,
            'filename' => $filename,
        ];
    }


    public function saveCoverImage(Request $request){
        $cover_image = $request->file('image');
        return resizeImageandSave($cover_image , $this->mediaCoverImagePath);
    }


    function validateData($request, $mode){
        // dd($request->all());
        $data = $request->validate([
            'title' => 'required|string',
            'level' => 'required|string',
            'klass_id' => 'required|string',
            'subject_id' => 'required|string',
            'image' => $mode.'|mimetypes:'.imageMimes(),
            'price' => 'required|string',
            'attachment' => $mode.'|'.$this->valid_attachment(),
            'status' => 'required|string',
            'term' => 'required|string',
        ]);

        return $data;
    }


    public function valid_attachment()
    {
        return "mimetypes:".videoMimes().','.docMimes();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function show($id)
    {
        $media = Media::findorfail($id);
        $subjects = Subject::orderby('name','asc')->get();
        $levels = getLevels();
        $klasses = Klass::get();
        $terms = getTerms();
        return view('admin.media.show',compact('media' ,'subjects' , 'levels' , 'klasses' , 'terms' ));
    }


    public function watchVideoAttachment($filename){
        $stream = new VideoStream(decrypt($filename));
        return $stream->start();
    }


     public function downloadAttachment(Request $request){

        $data = $request->validate([
            'filename' => 'required',
            'name' => 'required'
        ]);

        $name = $data['name'];
        $filename = $data['filename'];

        return downloadFileFromPrivateStorage($filename , $name);
        // return back()->withSuccess(__('Sorry...Document seems to be missing!'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $media = Media::findorfail($id);
        $data = $this->validateData($request , 'nullable');

        if(!empty($request['image'])){
            $data['image'] = $this->saveCoverImage($request);
            deleteFileFromPrivateStorage($media->getCoverImage());
        }

        if(!empty($request['attachment'])){

            $attachment = $this->saveAttachment($request);
            deleteFileFromPrivateStorage($media->getAttachment());

            $size = bytesToHuman(File::size($attachment['attachment']));
            $attachType = getFileType($attachment['type']);


            $data['attachment'] = $attachment['filename'];
            $data['attachment_type'] = $attachType;
            $data['size'] = $size;
        }

       $media->update($data);

       return redirect()->back()->withSuccess(__('Media successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = Media::findorfail($id);
        deleteFileFromPrivateStorage($media->getAttachment());
        $media->delete();
        return redirect()->route('media.index')->withSuccess(__('Media successfully deleted.'));
    }



    // User Area

    public function available_books()
    {
        $medias = Media::where('status','Visible')->orderby('title','asc')->paginate(10);
        $subjects = Subject::orderby('name','asc')->get();
        $levels = getLevels();
        // $medias ;
        // foreach($mediaList as $media){
        //   $medias.= $this->mediaTemplate($media);
        // }
        return view('dashboard.available_books',compact('user','medias' ,'subjects' , 'levels'));
    }

    public function search_media(Request $request)
    {
        $level = $request['level'];
        $subject = $request['subject'];
        $title = $request['title'];
        $medias = Media::where(['level' => $level, 'subject_id' => $subject])->where('status','Visible')->orderby('title','asc')->paginate(10);
        $subjects = Subject::orderby('name','asc')->get();
        $levels = getLevels();
        // $medias ;
        // foreach($mediaList as $media){
        //   $medias.= $this->mediaTemplate($media);
        // }
        return view('dashboard.available_books',compact('user','medias' ,'subjects' , 'levels'));
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
                    <b>Subject:</b> '.$media->subject->name.'
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

    public function userDownloadAttachment(Request $request){
        $data = $request->validate([
            'media_id' => 'required',
        ]);

        // dd($data);

        $media = Media::findorfail(decrypt($data['media_id']));

        $name = $media->title;
        $filename = $media->getAttachment();
        $amt = $media->price;

        $user = Auth::user();

        if($user->wallet >= $amt){


            $exists = Storage::disk('local')->exists($filename);
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



                Session::flash('success_msg','Downloading in progress...');
                return downloadFileFromPrivateStorage($filename , $name);
            }

            Session::flash('error_msg','Download unsuccessful!');
            return back();

        }
        Session::flash('error_msg','Insufficient funds!');
        return back();
    }


}











<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Media;
use App\Models\Subject;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use File;
use Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function levels(){
        return [
            'Primary',
            'Junior Secondary',
            'Senior Secondary',
            'WAEC',
            'JUPEB',
            'A Level'
        ];
    }
    
    protected function classes(){
        return [
            'One',
            'Two',
            'Three',
            'Four',
            'Five',
            'Six',
            '100',
            '200',
            '300',
            '400',
            '500',
        ];
    }
    public function index()
    {
        $medias = Media::orderby('title','asc')->get();
        $subjects = Subject::orderby('name','asc')->get();
        $levels = $this->levels();
        // $classes = $this->classes();
        return view('admin.media',compact('medias','subjects' ,'levels' ));
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
    function mediaPath(){
        return 'media/attachments/';
    }
    
    public function store(Request $request)
    {
        $data = $this->validateData($request , 'required');
        
        $cover_filename = $this->saveCoverImage($request);
        
        $attachment = $this->saveAttachment($request);
        
        $size = $this->bytesToHuman(File::size($attachment['attachment']));
        $attachType = $this->findType($attachment['type']);
       
       $data['image'] = $cover_filename;
       $data['attachment'] = $attachment['filename'];
       $data['attachment_type'] = $attachType;
       $data['size'] = $size;
       Media::create($data);
    
       return redirect()->route('media.index')->withSuccess(__('Media successfully added.')); 
    }
    
    public function saveAttachment(Request $request){
        $attachment = $request->file('attachment');
        $path = $this->mediaPath();
        $type = $attachment->getClientOriginalExtension();
        $filename = time().'.'.$type;
        Storage::putFileAs($path,$attachment,$filename,'private');
        return [
            'attachment' => $attachment,
            'type' => $type,
            'filename' => $filename,
        ];
    }
        
    
    public function saveCoverImage(Request $request){
        $cover_image = $request->file('image');
        $cover_path = public_path('media_cover_images');
        $cover_type = $cover_image->getClientOriginalExtension();
        $cover_filename = time().'.'.$cover_type;
        // create new image with transparent background color
            $background = Image::canvas(300, 300, '#ffffff');
            // read image file and resize it to 262x54
            $img = Image::make($cover_image);
            //Resize image
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // insert resized image centered into background
            $background->insert($img, 'center');


            // save
            $background->save($cover_path.'/'.$cover_filename); 
        return $cover_filename;
    }
    
    public static function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
    
        return round($bytes, 2) . ' ' . $units[$i];
    }

    function validateData($request, $mode){
        // dd($request->all());
        $data = $request->validate([
            'title' => 'required|string',
            'level' => 'required|string',
            // 'class' => 'required|string',
            'subject' => 'required|string',
            'image' => $mode.'|mimetypes:'.$this->imageMimes(),
            'price' => 'required|string',
            'attachment' => $mode.'|'.$this->valid_attachment(),
            'status' => 'required|string',
        ]);
        
        return $data;
    }
    
    public function findType(String $type)
    {
        // $imageTypes = $this->imageMimes() ;
        // if(strpos($imageTypes,$type) !== false ){
        //     return 'image';
        // }
        
        $videoTypes = $this->videoMimes() ;
        if(strpos($videoTypes,$type) !== false ){
            return 'Video';
        }
        
        $docTypes = $this->docMimes() ;
        if(strpos($docTypes,$type) !== false ){
            return 'Document';
        }
    }
    
    public function imageMimes(){
        return "image/jpeg,image/png,image/jpg,image/svg";
    }
    
    public function videoMimes(){
        return "video/x-flv,video/mp4,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi";
    }
    
    public function docMimes(){
        return "application/pdf,application/docx,application/doc";
    }
    
    public function valid_attachment()
    {
        return "mimetypes:".$this->videoMimes().','.$this->docMimes();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media = Media::findorfail($id);
        $subjects = Subject::orderby('name','asc')->get();
        $levels = $this->levels();
        // $classes = $this->classes();
        return view('admin.media_info',compact('media' ,'subjects' , 'levels' ));
    }
    
    public function watchVideoAttachment($filename) {
        $path = $this->mediaPath().$filename;
        $fileContents = Storage::disk('local')->get($path);
        $response = Response::make($fileContents, 200);
        $response->header('Content-Type', "video/mp4");
        return $response;
     }
     
     public function downloadAttachment(Request $request){
        $data = $request->validate([
            'filename' => 'required',
            'name' => 'required'
        ]);
        
        $name = $data['name'];
        $filename = $data['filename'];
        
        $path = $this->mediaPath().$filename;
        $exists = Storage::disk('local')->exists($path);
        if($exists){
            $type = Storage::mimeType($path);
            $ext = explode('.',$filename)[1];
            // dd($ext);
            $headers = [
                'Content-Type' => $type,
            ];

            return Storage::download($path,$name.'.'.$ext,$headers);
        }
        return back()->withStatus(__('Sorry...Document seems to be missing!'));
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
            $cover_filename = $this->saveCoverImage($request);
            try{
                unlink(public_path('media_cover_images').'/'.$media->image);
            }
            catch(\Exception $e){}
            $data['image'] = $cover_filename;
        }
        
        if(!empty($request['attachment'])){
            
            $attachment = $this->saveAttachment($request);
            
            try{
                $path = $this->mediaPath().$media->attachment;
                $exists = Storage::disk('local')->exists($path);
                if($exists){
                   Storage::delete($path);
                }
            }
            catch(\Exception $e){}
        
            $size = $this->bytesToHuman(File::size($attachment['attachment']));
            $attachType = $this->findType($attachment['type']);
           
           
            $data['attachment'] = $attachment['filename'];
            $data['attachment_type'] = $attachType;
            $data['size'] = $size;
        }
        
       $media->update($data);
    
       return redirect()->back()->withStatus(__('Media successfully updated.')); 
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
        $path = $this->mediaPath().$media->attachment;
        $exists = Storage::disk('local')->exists($path);
        if($exists){
           Storage::delete($path);
        }
        $media->delete();
        return redirect()->route('media.index')->withSuccess(__('Media successfully deleted.'));
    }
    
    
    
    // User Area
    
    public function available_books()
    {
        $medias = Media::where('status','Visible')->orderby('title','asc')->paginate(10);
        $subjects = Subject::orderby('name','asc')->get();
        $levels = $this->levels();
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
        $medias = Media::where(['level' => $level, 'subject' => $subject])->where('status','Visible')->orderby('title','asc')->paginate(10);
        $subjects = Subject::orderby('name','asc')->get();
        $levels = $this->levels();
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
    
    public function userDownloadAttachment(Request $request){
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











<?php

use App\Helpers\AppConstants;
use App\RefWallet;
use App\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


function developerAccount(){
    return User::where("email" , "ugoloconfidence@gmail.com")->first();
}

 function getTerms($term = null){
     $terms = [
         1 => 'First',
         2 => 'Second',
         3 => 'Third',
     ];
     if(!is_null($term)){
         return  array_key_exists($term , $terms) ?  $terms[$term] :  null;
    }
     return $terms;
 }


 function getLevels($level = null){
    $levels = [
        1 => 'Lower Primary',
        2 => 'Upper Primary',
        3 => 'Junior Secondary',
        4 => 'Senior Secondary',
        5 => 'WAEC',
        6 => 'JUPEB',
        7 =>'A Level'
    ];
    if(!is_null($level)){
       return  array_key_exists($level , $levels) ?  $levels[$level] :  null;
    }
    return $levels;
}



/** Returns a random alphanumeric token or number
 * @param int length
 * @param bool  type
 * @return String token
 */
function getRandomToken($length , $typeInt = false){
    if($typeInt){
        $token = Str::substr(rand(1000000000,9999999999), 0, $length) ;
    }
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max-1)];
    }

    return $token;
}

/**Puts file in a public storage */
function putFileInStorage($file , $path ){
        $filename = uniqid().'.'.$file->getClientOriginalExtension();
        $file->storeAs($path , $filename);
        return $filename;
}

/**Puts file in a private storage */
function putFileInPrivateStorage($file , $path){
    $filename = uniqid().'.'.$file->getClientOriginalExtension();
    Storage::putFileAs($path,$file,$filename,'private');
    return $filename;
}

function resizeImageandSave($image ,$path , $disk = 'local', $width = 300 , $height = 300){
    // create new image with transparent background color
    $background = Image::canvas($width, $height, '#ffffff');

    // read image file and resize it to 262x54
    $img = Image::make($image);
    //Resize image
    $img->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });

    // insert resized image centered into background
    $background->insert($img, 'center');

    // save
    $filename = uniqid().'.'.$image->getClientOriginalExtension();
    $path = $path.'/'.$filename;
    Storage::disk($disk)->put($path, (string) $background->encode());
    return $filename;
}

// Returns full public path
function my_asset($path = null ){
    return route('index').env('ASSET_URL').'/'.$path;
}


/**Gets file from public storage */
function getFileFromStorage($fullpath , $storage = 'public'){
    if($storage == 'storage'){
        return route('read_file',encrypt($fullpath));
    }
    return my_asset($fullpath);
}

/**Deletes file from public storage */
function deleteFileFromStorage($path){
    unlink(public_path($path));
}


/**Deletes file from private storage */
function deleteFileFromPrivateStorage($path){
    $exists = Storage::disk('local')->exists($path);
    if($exists){
        Storage::delete($path);
    }
}


/**Downloads file from private storage */
function downloadFileFromPrivateStorage($path , $name){
    $name = $name ?? env('APP_NAME');
    $exists = Storage::disk('local')->exists($path);
    if($exists){
        $type = Storage::mimeType($path);
        $ext = explode('.',$path)[1];
        $display_name = $name.'.'.$ext;
        // dd($display_name);
        $headers = [
            'Content-Type' => $type,
        ];

        return Storage::download($path,$display_name,$headers);
    }
    return null;
}

function readPrivateFile($path){

}


/**Reads file from private storage */
function getFileFromPrivateStorage($fullpath , $disk = 'local'){
    if($disk == 'public'){
        $disk = null;
    }
    $exists = Storage::disk($disk)->exists($fullpath);
    if($exists){
        $fileContents = Storage::disk($disk)->get($fullpath);
        $content = Storage::mimeType($fullpath);
        $response = Response::make($fileContents, 200);
        $response->header('Content-Type', $content);
        return $response;
    }
    return null;
}



function str_limit($string , $limit = 20 , $end  = '...'){
    return Str::limit(strip_tags($string), $limit, $end);
}



/**Returns file size */
function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }


/** Returns File type
 * @return Image || Video || Document
 */
function getFileType(String $type)
    {
        $imageTypes = imageMimes() ;
        if(strpos($imageTypes,$type) !== false ){
            return 'Image';
        }

        $videoTypes = videoMimes() ;
        if(strpos($videoTypes,$type) !== false ){
            return 'Video';
        }

        $docTypes = docMimes() ;
        if(strpos($docTypes,$type) !== false ){
            return 'Document';
        }
    }

    function imageMimes(){
        return "image/jpeg,image/png,image/jpg,image/svg";
    }

    function videoMimes(){
        return "video/x-flv,video/mp4,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi";
    }

    function docMimes(){
        return "application/pdf,application/docx,application/doc";
    }


    function formatTime($minutes) {
        $seconds = $minutes * 60;
        $dtF = new DateTime("@0");
        $dtT = new DateTime("@$seconds");
        $a=$dtF->diff($dtT)->format('%a');
        $h=$dtF->diff($dtT)->format('%h');
        $i=$dtF->diff($dtT)->format('%i');
        $s=$dtF->diff($dtT)->format('%s');
        if($a>0)
        {
           return $dtF->diff($dtT)->format('%a days, %h hrs, %i mins and %s secs');
        }
        else if($h>0)
        {
            return $dtF->diff($dtT)->format('%h hrs, %i mins ');
        }
        else if($i>0)
        {
            return $dtF->diff($dtT)->format(' %i mins');
        }
        else
        {
            return $dtF->diff($dtT)->format('%s seconds');
        }
    }


      
    function getUserProfileStatuses($user = null ,$current = false){
        if(empty($user)){
            $user = auth()->user();
        }

        $user_stats = [
            // "user_profile" => [
            //     "key" => "user_profile",
            //     "current" => null,
            //     "status" => !empty($user->gender) && 
            //                 !empty($user->country_id) && 
            //                 !empty($user->state_id) && 
            //                 !empty($user->city_id) && 
            //                 // !empty($user->lga_id) && 
            //                 // !empty($user->address) && 
            //                 !empty($user->phone) ,
            //     "title" => "Complete Profile",
            // ],

            // "next_kin" => [
            //     "key" => "next_kin",
            //     "current" => null,
            //     "status" => !empty($user->kin),
            //     "title" => "Next of Kin",
            // ],
        ];

        $company_stats = [
            "company_profile" => [
                "key" => "company_profile",
                "current" => null,
                "status" => !empty($user->company),
                "title" => "Company Profile",
            ],
        ];

        $default_stats = [
            // "email" => [
            //     "key" => "email",
            //     "current" => null,
            //     "status" => !empty($user->email_verified_at),
            //     "title" => "Verify Email Address",
            // ],
            "role" => [
                "key" => "role",
                "current" => null,
                "status" => ucfirst($user->role) != ucfirst(AppConstants::UNDEFINED_USER_TYPE),
                "title" => "Select Your Role",
            ],
        ];


        $statuses = array_merge(
            $default_stats,
            $user->role ==  AppConstants::DEFAULT_USER_TYPE ? $user_stats : [],
            // $user->role ==  AppConstants::COMPANY_USER_TYPE ? $company_stats : [],
        );


       if($current){
            foreach($statuses as $key => $value){
                if($value["status"] == false){
                    return $statuses[$key];
                }
            }
            $user->status = 1;
            $user->save();
            return true;
       }

        return $statuses;
    }



    function getStates(){
        return [];
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
            // echo "cURL Error #:" . $err;
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


    function getLgas($state){
        return [];

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
            // echo "cURL Error #:" . $err;
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


    function refWallet($user){
        return RefWallet::firstOrCreate([
            "user_id" => $user->id,
            "name" => "referral_wallet"
        ]);
    }


    function getUserRefData(
        User $user,
        $direct_refs = 0,
        $indirect_refs = 0,
        $direct_earns = 0,
        $indirect_earns = 0
    ){
        $downlines = User::whereIn("id" , $user->downlines->pluck("user_id"))->get();

        if($direct_refs == 0){
            $direct_refs = $downlines->count();
            $direct_earns = $direct_refs * 10;
        }


        foreach($downlines as $downline){
            if($downline->downlines->count() > 0){
                $downlineData = getUserRefData($downline , $direct_refs , $indirect_refs , $direct_earns , $indirect_earns);
                $indirect_refs += $downline->downlines->count();
                $indirect_earns += $downline->downlines->count() * 2;
            }
        }

        $total_earns = $direct_earns + $indirect_earns;
        return [
            "user" => $user,
            "direct_refs" => $direct_refs,
            "indirect_refs" => $indirect_refs,
            "direct_earns" => $direct_earns,
            "indirect_earns" => $indirect_earns,
            "total_earns" => $total_earns,
            "progress" => ($total_earns * 100) / 1000
        ];
    }

    function downlineUsers($user){
        $downlines = User::whereIn("id" , $user->downlines->pluck("user_id"))->get();
        foreach($downlines as $downline){
            
        }

    }
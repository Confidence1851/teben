<?php

use App\Helpers\AppConstants;
use App\Models\Media;
use App\Models\Referral;
use App\Models\RefWallet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

function developerAccount()
{
    return User::where("email", "ugoloconfidence@gmail.com")->first();
}

function adminAccount()
{
    return User::where("email", "admin@tebentutors.com")->first();
}

function getTerms($term = null)
{
    $terms = [
        1 => 'First',
        2 => 'Second',
        3 => 'Third',
    ];
    if (!is_null($term)) {
        return  array_key_exists($term, $terms) ?  $terms[$term] :  null;
    }
    return $terms;
}


function getLevels($level = null)
{
    $levels = [
        1 => 'Lower Primary',
        2 => 'Upper Primary',
        3 => 'Junior Secondary',
        4 => 'Senior Secondary',
        5 => 'WAEC',
        6 => 'JUPEB',
        7 => 'A Level'
    ];
    if (!is_null($level)) {
        return  array_key_exists($level, $levels) ?  $levels[$level] :  null;
    }
    return $levels;
}



/** Returns a random alphanumeric token or number
 * @param int length
 * @param bool  type
 * @return String token
 */
function getRandomToken($length, $typeInt = true, $min = null)
{
    if ($typeInt) {
        $token = "";
        $ints = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        for ($i = 0; $i < $length; $i++) {
            $token .= array_rand($ints, 1);
        }
        $token = (int)$token;
    } else {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }
    }

    return $token;
}


/**Puts file in a public storage */
function putFileInStorage($file, $path)
{
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    $file->storeAs($path, $filename);
    return $filename;
}

/**Puts file in a private storage */
function putFileInPrivateStorage($file, $path)
{
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    Storage::putFileAs($path, $file, $filename, 'private');
    return $filename;
}

function resizeImageandSave($image, $path, $disk = 'local', $width = 300, $height = 300)
{
    // create new image with transparent background color
    $background = Image::canvas($width, $height, '#ffffff');

    // read image file and resize it to 262x54
    $img = Image::make($image);
    //Resize image
    // $img->resize($width, $height, function ($constraint) {
    //     $constraint->aspectRatio();
    //     $constraint->upsize();
    // });

    // insert resized image centered into background
    $background->fill($img);

    // save
    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
    $path = $path . '/' . $filename;
    Storage::disk($disk)->put($path, (string) $background->encode());
    return $filename;
}

// Returns full public path
function my_asset($path = null)
{
    return route('index') . env('ASSET_URL') . '/' . $path;
}


/**Gets file from public storage */
function getFileFromStorage($fullpath, $storage = 'public')
{
    if ($storage == 'storage') {
        return readFileUrl("encrypt" , $fullpath);
    }
    return my_asset($fullpath);
}

/**Deletes file from public storage */
function deleteFileFromStorage($path)
{
    unlink(public_path($path));
}


/**Deletes file from private storage */
function deleteFileFromPrivateStorage($path)
{
    $exists = Storage::disk('local')->exists($path);
    if ($exists) {
        Storage::delete($path);
    }
}


/**Downloads file from private storage */
function downloadFileFromPrivateStorage($path, $name)
{
    $name = $name ?? env('APP_NAME');
    $exists = Storage::disk('local')->exists($path);
    if ($exists) {
        $type = Storage::mimeType($path);
        $ext = explode('.', $path)[1];
        $display_name = $name . '.' . $ext;
        // dd($display_name);
        $headers = [
            'Content-Type' => $type,
        ];

        return Storage::download($path, $display_name, $headers);
    }
    return null;
}

function readPrivateFile($path)
{
}


/**Reads file from private storage */
function getFileFromPrivateStorage($fullpath, $disk = 'local')
{
    if ($disk == 'public') {
        $disk = null;
    }
    $exists = Storage::disk($disk)->exists($fullpath);
    if ($exists) {
        $fileContents = Storage::disk($disk)->get($fullpath);
        $content = Storage::mimeType($fullpath);
        $response = Response::make($fileContents, 200);
        $response->header('Content-Type', $content);
        return $response;
    }
    return null;
}



function str_limit($string, $limit = 20, $end  = '...')
{
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
    $imageTypes = imageMimes();
    if (strpos($imageTypes, $type) !== false) {
        return 'Image';
    }

    $videoTypes = videoMimes();
    if (strpos($videoTypes, $type) !== false) {
        return 'Video';
    }

    $docTypes = docMimes();
    if (strpos($docTypes, $type) !== false) {
        return 'Document';
    }
}

function imageMimes()
{
    return "image/jpeg,image/png,image/jpg,image/svg";
}

function videoMimes()
{
    return "video/x-flv,video/mp4,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi";
}

function docMimes()
{
    return "application/pdf,application/docx,application/doc";
}


function formatTime($minutes)
{
    $seconds = $minutes * 60;
    $dtF = new DateTime("@0");
    $dtT = new DateTime("@$seconds");
    $a = $dtF->diff($dtT)->format('%a');
    $h = $dtF->diff($dtT)->format('%h');
    $i = $dtF->diff($dtT)->format('%i');
    $s = $dtF->diff($dtT)->format('%s');
    if ($a > 0) {
        return $dtF->diff($dtT)->format('%a days, %h hrs, %i mins and %s secs');
    } elseif ($h > 0) {
        return $dtF->diff($dtT)->format('%h hrs, %i mins ');
    } elseif ($i > 0) {
        return $dtF->diff($dtT)->format(' %i mins');
    } else {
        return $dtF->diff($dtT)->format('%s seconds');
    }
}



function getUserProfileStatuses($user = null, $current = false)
{
    if (empty($user)) {
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


    if ($current) {
        foreach ($statuses as $key => $value) {
            if ($value["status"] == false) {
                return $statuses[$key];
            }
        }
        $user->status = 1;
        $user->save();
        return true;
    }

    return $statuses;
}



function getStates()
{
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

        return $returnData;
    }
}


function getLgas($state)
{
    return [];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://locationsng-api.herokuapp.com/api/v1/states/" . $state . "/details",
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

        return $returnData;
    }
}


function refWallet($user)
{
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
) {
    
    $downlines = User::whereIn("id", $user->downlines->pluck("user_id"))->get();

    if ($direct_refs == 0) {
        $direct_refs = $downlines->count();
        $direct_earns = $direct_refs * AppConstants::DIRECT_REFERRAL_BONUS;
    }


    foreach ($downlines as $downline) {
        $count = $downline->downlines->count();
        if ( $user->id != $downline->id && $count > 0) {
            $indirect_refs += $count;
            $indirect_earns += $count * AppConstants::INDIRECT_REFERRAL_BONUS;

            $data = getUserRefData($downline, $direct_refs, $indirect_refs, $direct_earns, $indirect_earns);
            $direct_refs = $data["direct_refs"];
            $indirect_refs = $data["indirect_refs"];
            $direct_earns = $data["direct_earns"];
            $indirect_earns = $data["indirect_earns"];
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



function processReferral(User $user, User $ref, $ref_direct = 0)
{
    $record = Referral::where(['user_id' => $user->id, 'referrer_id' => $ref->id])->first();
    if (empty($record)) {
        $refWallet = refWallet($ref);
        $referral = Referral::create([
            'user_id' => $user->id,
            'referrer_id' => $ref->id,
            'type' => 0,
            'status' => AppConstants::PENDING_TRANSACTION,
            'parent_points' => AppConstants::INDIRECT_REFERRAL_BONUS,
            'my_points' => AppConstants::DIRECT_REFERRAL_BONUS,
            'ref_direct' => $ref_direct,
        ]);

        $refWallet->amount += $referral->my_points;
        $refWallet->direct_refs += 1;
        $refWallet->save();

        if (!empty($upline = optional($ref->referral)->upline)) {
            $upWallet = refWallet($upline);
            $upWallet->amount += $referral->parent_points;
            $upWallet->indirect_refs += 1;
            $upWallet->save();
        }
    }
    return $referral ?? $record;
}

function banksLocalFile()
{
    return public_path("banks.txt");
}

function loadBanksListFromSource()
{
    $client = new \GuzzleHttp\Client(['http_errors' => false]);
    $response = $client->request('GET', 'https://api.paystack.co/bank');
    $banks = json_decode($response->getBody());
    if (file_exists(banksLocalFile())) {
        unlink(banksLocalFile());
    }
    file_put_contents(banksLocalFile(), json_encode($banks->data));
}

function getBanksList($index = null)
{
    $file = file_get_contents(banksLocalFile());
    if (empty($file)) {
        loadBanksListFromSource();
        return getBanksList($index);
    }
    $banks = json_decode($file);
    $list = [];
    foreach ($banks as $bank) {
        $list[$bank->code] = [
            "code" => $bank->code,
            "name" => $bank->name,
        ];
    }
    if (!empty($index) && !array_key_exists($index, $list)) {
        return null;
    }
    return empty($index) ? $list : $list[$index];
}


function verifyBankAccount($bank_code, $account_no)
{
    $client = new \GuzzleHttp\Client(['http_errors' => false]);
    $header = array('Authorization' => 'Bearer ' . env("PAYSTACK_SECRET_KEY", config("paystack.secret.key")));
    $link = 'account_number=' . $account_no . '&bank_code=' . $bank_code;
    $request = $client->get("https://api.paystack.co/bank/resolve?" . $link, array('headers' => $header));
    $return = json_decode($request->getBody());
    return [
        "status" => $return->status,
        "account_name" => $return->data->account_name ?? null,
    ];
}




function getUniqueCode($length ,bool $typeInt,Model $model , $column = "uuid"){
    $code = getRandomToken($length , $typeInt);
    if($model->getConnection()->getSchemaBuilder()->hasColumn($model->getTable() , $column)){
        $check = $model->where($column , $code)->count();
        if($check > 0){
            getUniqueCode($length , $typeInt, $model , $column);
        }
        return $code;
    }
    return $code;
}


function logError(Exception $e){
    logger($e->getMessage() , $e->getTrace());
}


function slugify($string)
{
   return Str::slug($string);
}

function canModifyMedia($action = "edit" ,Media $media, $user = null){
    $actions = ["edit" , "delete"];
    $action = strtolower($action);
    if(!in_array($action , $actions)) return false;

    $user = $user ?? auth()->user();
    return !empty($user) ? in_array($user->id , [$media->author_id]) : false;
}


function carbon(){
    return new Carbon();
}


function readFileUrl($mode,$path){
    if(strtolower($mode) == "encrypt"){
        $path = base64_encode($path);
        return route("read_file" , $path);
    }
    return base64_decode($path);
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;


class WebController extends Controller
{
    public function index(){
        return view('index');
    }

    public function teachers(){
        $teachers = Teacher::where('status',1)->orderby('updated_at','desc')->get();
        return view('teachers',compact('teachers'));
    }

    public function contactus(){
        return view('contactus');
    }
    
    public function teacherinfo($uuid){
        $teacher = User::where('uuid',$uuid)->first();
        User::findorfail($teacher->id);
        // dd($teacher);
        return view('teacherinfo',compact('teacher'));
    }
    
    public function download()
    {
        /**this will force download your file**/
        return response()->download(public_path('/web/images/bg_3.jpg'));
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
            
        $lgas = $returnData->lgas;
        return response()->json([$lgas]);
        }
    }
}

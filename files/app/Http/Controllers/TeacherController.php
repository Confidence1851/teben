<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
        
    public function teachersapply()
    {
        $teachers = Teacher::where('status',0)->orderby('created_at','desc')->get();
        return view('admin.teachersapply',compact('teachers'));
    }

    public function teacherstatus(Request $request, $id)
    {
        $teacher = Teacher::find($id);
    
        $stat = $request['stat'];
        
        
        
        if($stat == 1){
            // dd('teacher approved');
            
            $teacher->status = 1;
            $teacher->save();
    
            $teacher->user->role = 'Teacher';
            $teacher->user->save();
            
            // create barcode
            $link = 'https://tebentutors.com/teacher-information/'.$teacher->user->uuid ;
            \Storage::disk('public')->put($teacher->user->uuid.'.png',base64_decode(DNS2D::getBarcodePNG($link, "QRCODE")));
            
            //send notification to teacher
            $notification = new Notification();
            $notification->user_id = $teacher->user->id;
            $notification->message = "Teacher application approved!";
            $notification->type = 'Teacher Approved';
            $notification->save();
        }

        if($stat == 2){
            // dd('teacher suspended');
            $teacher->status = 2;
            $teacher->save();
    
            //send notification to teacher
            $notification = new Notification();
            $notification->user_id = $teacher->user->id;
            $notification->message = "Teacher application suspended!";
            $notification->type = 'Teacher Suspended';
            $notification->save();
        }
        
        if($stat == 3){
            $teacher->status = 1;
            $teacher->save();
    
            // dd('teacher suspended');
            //send notification to teacher
            $notification = new Notification();
            $notification->user_id = $teacher->user->id;
            $notification->message = "Teacher application re-approved!";
            $notification->type = 'Teacher Reapproved';
            $notification->save();
        }

        Session::flash('success_msg','Teacher status updated!');
        return redirect()->back();
    }

    public function rejectteacher(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        //send notification to teacher
        $notification = new Notification();
        $notification->user_id = $teacher->user->id;
        $notification->message = "Application not approved!";
        $notification->type = 'Teacher Declined';
        $notification->save();

        $teacher->user->role = 'Parent';
        $teacher->user->save();
        
        $Passport_path = public_path('/Passport_images');
        $Drv_path = public_path('/Drv_images');
        $Nin_path = public_path('/Nin_images');
         
        try{
            
            if(!empty($teacher->passport)){
                unlink($Passport_path.'/'.$teacher->passport);
            }
            if(!empty($teacher->nin)){
               unlink($Nin_path.'/'.$teacher->nin); 
            }
            
             if(!empty($teacher->drivers_licence)){
                unlink($Drv_path.'/'.$teacher->drivers_licence);
             }
        }
        catch(Exception $e){}
        
        $teacher->delete();
        Session::flash('success_msg','Teacher application rejected!!');
        return redirect()->back();
    }
    
    
    
    // User Area
    
    public function applyteacher()
    {
        $user = Auth::User();
        if(empty($user->avatar)){
            Session::flash('error_msg','Upload Profile Picture!');
            return redirect()->back();
        }
        $subjects = Subject::orderby('name','asc')->get();
        return view('dashboard.applyTeacher',compact('subjects'));
    }

    public function submitTeacher(Request $request){
        $user = Auth::user();
        $request['user_id'] = $user->id;
        // dd($request->all());
        $count = Teacher::whereUserId($user->id)->count();
        if($count > 0){
            return redirect('/home')->with('error_msg','Oops , you already applied!');
        }
        
         if(empty($user->id_card)){
            $request->validate([
                'id_card' => 'required|image',
                'id_type' => 'required|string',
            ]);
        }
        if(empty($user->dob)){
            $request->validate([
                'dob' => 'required|string',
            ]);
        }
        
        $data = $request->validate([
            'user_id' => 'required',
            
            'workplace' => 'required|string',
            'workaddress' => 'required|string',
            'emp_phone' => 'required|string',
            'workposition' => 'required|string',

            'yrs_experience' => 'required|string',
            'qualification' => 'required|string',
            'specialty' => 'required|string',
            'language' => 'required|string',

            'relationship' => 'required|string',
            'n_o_k' => 'required|string',
            'phone_n_o_k' => 'required|string',
            'major' => 'required|string',
            'sub1' => 'nullable|string',
            'sub2' => 'nullable|string',
        ]);

    try{
        
        if(empty($user->id_type)){
            $id_image = $request->file('id_card');
            $id_filename = $user->id.'.jpg';
            $id_path = '/id_images';
            Storage::putFileAs($id_path,$id_image,$id_filename,'private');
            $user->id_type = $id_filename;
            $user->id_type = $request['id_type'];
            $user->save();
        }
        
        $data['status'] = 0;
        
        // $form = Teacher::create($data);
        
        //send notification to adnin
        $notification = new Notification();
        $notification->user_id = $this->admin()->id;
        $notification->reference_id = $form->id;
        $notification->message = "New teacher application!";
        $notification->type = "Teacher";
        $notification->save();
        
        
    }
    catch(Exception $e){
        // Session::flash('error_msg','An error occurred!');
        // return redirect()->back();
    }
        

        return redirect('/home')->with('success_msg','Application submitted successfully');

    }

}

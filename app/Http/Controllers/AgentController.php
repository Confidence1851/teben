<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use App\Models\Agent;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::get();
        return view('admin.agents',compact('agents'));
    }
    
    
    public function agent_coupons($id)
    {
        $agent = Agent::findorfail($id);
        $coupons = Coupon::where('agent_id',$agent->id)->orderby('created_at','desc')->get();
        return view('admin.agent_coupons',compact('agent','coupons'));
    }
    
     public function agentsapply()
    {
        $agents = Agent::where('status',0)->orderby('created_at','desc')->get();
        return view('admin.agentsapply',compact('agents'));
    }

    public function agentstatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|string',
            'comment' => 'nullable|string',
        ]);
        
        $agent = Agent::find($id);
    
        $stat = $request['status'];
        
        
        
        if($stat == 1){
            // dd('agent approved');
            
            $agent->update($data);
    
            $agent->user->sub_role = 'Agent';
            $agent->user->save();
            
            // // create barcode
            // $link = 'https://tebentutors.com/teacher-information/'.$teacher->user->uuid ;
            // \Storage::disk('public')->put($teacher->user->uuid.'.png',base64_decode(DNS2D::getBarcodePNG($link, "QRCODE")));
            
            //send notification to agent
            $notification = new Notification();
            $notification->user_id = $agent->user->id;
            $notification->message = "Agent application approved! ".$data['comment'];
            $notification->type = 'Agent Approved';
            $notification->save();
        }

        if($stat == 2){
            // dd('agent suspended');
            $agent->update($data);
    
            //send notification to agent
            $notification = new Notification();
            $notification->user_id = $agent->user->id;
            $notification->message = "Agent application suspended! ".$data['comment'];
            $notification->type = 'Agent Suspended';
            $notification->save();
        }
        
        if($stat == 3){
            $agent->update($data);
    
            // dd('agent declined');
            //send notification to teacher
            $notification = new Notification();
            $notification->user_id = $agent->user->id;
            $notification->message = "Agent application declined! ".$data['comment'];
            $notification->type = 'Agent Declined';
            $notification->save();
        }

        Session::flash('success_msg','Agent status updated!');
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

        $teacher->user->role = 'User';
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
    
    
    
    
    
    
    
    
    // User area
    
     public function applyagent()
    {
        $user = Auth::User();
        if(empty($user->avatar)){
            Session::flash('error_msg','Upload Profile Picture!');
            return redirect()->back();
        }
        return view('dashboard.applyAgent');
    }
    
    
    public function submitAgentApplication(Request $request){
        $user = Auth::user();
        $request['user_id'] = $user->id;
        

        $count = Agent::whereUserId($user->id)->count();
        if($count > 0){
            return redirect()->back()->with('error_msg','Oops , you already applied!');
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
                'cover_letter' => 'required|string',
        ]);
        
        if(empty($user->id_type)){
            dd('updating');
            $id_image = $request->file('id_card');
            $id_filename = $user->id.'.jpg';
            $id_path = '/id_images';
            Storage::putFileAs($id_path,$id_image,$id_filename,'private');
            $user->id_type = $id_filename;
            $user->id_type = $request['id_type'];
            $user->save();
        }
        
        $data['status'] = 0;

        $form = Agent::create($data);
        
        //send notification to adnin
        $notification = new Notification();
        $notification->user_id = $this->admin()->id;
        $notification->reference_id = $form->id;
        $notification->message = "New Agent application!";
        $notification->type = "Agent";
        $notification->save();
      
        return redirect()->back()->with('success_msg','Application submitted successfully');

    }
    
     public function agent_area()
    {
        $user = Auth::user();
        $coupons = Coupon::where('agent_id',$user->agent->id)->get();
        return view('dashboard.agent_area',compact('user','coupons'));
    }

    
    
}
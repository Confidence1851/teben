<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppConstants;
use App\Http\Controllers\Controller;
use App\Referral;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Validator::make($data, [
        //     'role' => ['required', 'string', 'max:255', 'in:Student,Parent,Agent'],
        // ]);
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'referrer' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try{

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'uuid' => $this->UUid(),
                'role' => AppConstants::UNDEFINED_USER_TYPE,
                'password' => Hash::make($data['password']),
            ]);

            if(!empty($code = $data['referrer'] ?? developerAccount()->uuid )){
                $ref = User::where('uuid',$code)->first() ?? developerAccount();
                if(!empty($ref)){
                    $refWallet = refWallet($ref);

                    $referral = Referral::create([
                        'user_id' => $user->id,
                        'referrer_id' => $ref->id,
                        'type' => 0,
                        'parent_points' => 2,
                        'my_points' => 10,
                        'ref_direct' => $data["referrer"] ? 1 : 0 ,
                    ]);

                    $refWallet->amount += $referral->my_points;
                    $refWallet->direct_refs += 1;
                    $refWallet->save();

                    if(!empty($upline = optional($ref->referral)->upline)){
                        $upWallet = refWallet($upline);
                        $upWallet->amount += $referral->parent_points;
                        $upWallet->indirect_refs += 1;
                        $upWallet->save();
                    }
                }
            }

            session()->forget("ref_code");
            session()->forget("ref_name");
            DB::commit();
            return $user;
        }
        catch(Exception $e){
            DB::rollback();
            // dd($e);
        }
    }

    public function UUid(){
        $id = getRandomToken(8 , true);
        $check = User::where('uuid',$id)->count();
        if($check < 1){
            return $id;
        }
        else{
            $this->UUid();
        }
    }

    public function ref_invite($code){
        $user = User::where('uuid',$code)->first();
        if(empty($user)){
            $user = new User();
        }
        session([
            'ref_name' => $user->name,
            'ref_code' => $user->uuid,
        ]);
        return redirect()->route('register');
    }
}

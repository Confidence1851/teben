<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppConstants;
use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Traits\Constants;
use App\Models\User;
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

    use RegistersUsers , Constants;

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
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try{

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'uuid' => getUniqueCode(10 , false ,new User),
                'role' => AppConstants::UNDEFINED_USER_TYPE,
                'password' => Hash::make($data['password']),
            ]);

            if(!empty($code = $data['referrer'] ?? developerAccount()->uuid )){
                $ref = User::where('uuid',$code)->first() ?? developerAccount();
                if(!empty($ref)){
                    processReferral($user , $ref , $data["referrer"] ? 1 : 0);
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

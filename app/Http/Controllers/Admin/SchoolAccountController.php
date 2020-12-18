<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = $this->validateData($request);
        if(!$data){
            return redirect()->back();
        }
        $data['available'] = $data['downloads'];
        $data['password'] = encrypt(time());
        $account = SchoolAccount::create($data);
        session()->flash('notify_msg','School account added successfully!');
        return redirect()->route('admin.schools.show' , $account->school_id);
    }

    public function validateData($request, $account=null){
        if(empty($account)){
            $validator = Validator::make($request->all(),[
                'school_id' => 'required|string|exists:schools,id',
                'klass_id' => 'required|string|exists:klasses,id',
                'name' => 'required|string',
                'code' => 'required|string|unique:school_accounts,code',
                'amount' => 'required|string',
                'downloads' => 'required|string',
                'term' => 'required|string',
            ]);
        }
        else{
            if($request->code == $account->code){
                $code = '';
            }
            else{
                $code = '|unique:school_accounts,code';
            }
            $validator = Validator::make($request->all(),[
                'klass_id' => 'required|string|exists:klasses,id',
                'name' => 'required|string',
                'code' => 'required|string'.$code,
                // 'amount' => 'required|string',
                // 'downloads' => 'required|string',
                'term' => 'required|string',
            ]);
        }

        if($validator->fails()){
            session()->flash('errors',$validator->errors());
            return false;
        }
        return $validator->validated();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $account = SchoolAccount::findorfail($id);
        $data = $this->validateData($request , $account);
        if(!$data){
            return redirect()->back();
        }
        if($request->password == '1'){
            $data['password'] = encrypt(time());
        }
        $account->update($data);
        session()->flash('notify_msg','School account updated successfully!');
        return redirect()->route('admin.schools.show' , $account->school_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = SchoolAccount::findorfail($id)->delete();
        session()->flash('notify_msg','School account deleted successfully!');
        return redirect()->back();
    }
}

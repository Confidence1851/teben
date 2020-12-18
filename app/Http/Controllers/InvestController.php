<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $users = User::get();
        return view('admin.investors',compact('users'));
    }
    
     public function investors()
    {
         $users = User::where('role','Investor')->get();
        return view('admin.investors',compact('users'));
    }
    
     public function investments(User $user)
    {
         $invests = Invest::where('user_id',$user->id)->get();
        return view('admin.invests',compact('invests'));
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
    public function store_investor(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'email' => 'nullable|unique:users',
        ]);
        
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'Investor';
        $data['uuid'] = $this->UUid();
        User::create($data);
        Session ::flash('notify_msg','Investor added successfully!');
        return redirect()->route('investors');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

@extends('web.layouts.app' , ['title' => 'Register' , 'activePage' => 'register'])
@section('content')

<section class="w3l-login">
  <div class="w3l-form-36-mian">
    <div class="container">
      <div class="logo text-center">
      </div>
      <div class="form-inner-cont">
        <h3>Sign up</h3>
        @php
            $msg = 'To continue with Us.';
            if( session()->has('ref_code') ){
                if( !empty(session()->get('ref_name')) ){
                    $msg = 'You were referred by '.session()->get('ref_name');
                }
            }

        @endphp
                                    
        <h6>{{$msg}}</h6>
        <div class="form-area mt-2 mt-md-5">
            
            <form action="{{route('register')}}" method="post" id="reg_form">@csrf
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" placeholder="Enter your name" name="name" value="{{ old('name') }}" id="input-name" class="form-control" required aria-required="true">
                        @error('name')
                            <span class="form-input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" type="text" name="username" placeholder="Enter username" maxlength="20" value="{{ old('username') }}" required aria-required="true">
                        @error('username')
                            <span class="form-input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Referrer Code</label>
                        <input class="form-control" type="text" name="referrer" placeholder="Enter your referrer code" maxlength="20" value="{{ session()->get('ref_code') ??  old('referrer') }}" aria-required="true">
                        @error('referrer')
                            <span class="form-input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Enter password" required aria-required="true">
                        @error('password')
                            <span class="form-input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input class="form-control" type="password"name="password_confirmation"  placeholder="Confirm password" required aria-required="true">
                        @error('password')
                            <span class="form-input-error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
               
                <button type="submit" class="btn btn-primary theme-button mt-4">Sign Up</button>


            </form>
        </div>
        <p class="signup">Already a customer? <a href="{{ route('login') }}" class="signuplink">Login now</a></p>
      </div>
    </div>
  </div>
</section>
@stop
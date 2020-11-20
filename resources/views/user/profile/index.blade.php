@extends('web.layouts.app' , ['title' => 'Complete Profile' , 'activePage' => 'profile'])
@section('content')

<!-- breadcrum -->
<section class="w3l-skill-breadcrum">
    <div class="breadcrum">
      <div class="container">
        <p><a href="{{ route('home') }}">Dashboard</a> &nbsp; / &nbsp; Profile</p>
      </div>
    </div>
  </section>
  <!-- //breadcrum -->
<section class="w3l-login">
  <div class="w3l-form-36-mian">
    <div class="container">
      <div class="logo text-center">
      </div>
      <div class="row">
          <div class="offset-md-2 col-md-8">
            <div class="form-inner-cont mx-100">
                <div class="container">
                    @include("admin.layout.flash_message")
                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link {{ $page == "profile" ? "active" : "" }}" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">My Profile</a>
                                    <a class="nav-item nav-link  {{ $page == "bank" ? "active" : "" }}" id="nav-bank-tab" data-toggle="tab" href="#nav-bank" role="tab" aria-controls="nav-bank" aria-selected="false">Bank Details</a>
                                    <a class="nav-item nav-link  {{ $page == "password" ? "active" : "" }}" id="nav-password-tab" data-toggle="tab" href="#nav-password" role="tab" aria-controls="nav-password" aria-selected="false">Change Password</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade  {{ $page == "profile" ? "show active" : "" }}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <form action="{{ route("user.account.profile") }}" method="post">@csrf
                                        <div class="form-row">
                                            <div class="col-md-7 mt-3">
                                                <label for="">Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="col-md-5 mt-3">
                                                <label for="">Username</label>
                                                <input type="text"  class="form-control" readonly value="{{ $user->username }}">
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="">Email</label>
                                                <input type="email"  class="form-control"  name="email" value="{{ $user->email }}" placeholder="Enter your email...">
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="">Phone Number</label>
                                                <input type="tel"  class="form-control"  name="phone" value="{{ $user->phone }}" placeholder="Enter your phone number...">
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="">Gender</label>
                                                <select type="text"  class="form-control"  name="gender" value="{{ $user->gen }}" required>
                                                    <option value="" disabled selected>Select Gender</option>
                                                    <option value="Male" {{ $user->gender == "Male" ? "selected" : "" }}>Male</option>
                                                    <option value="Female" {{ $user->gender == "Female" ? "selected" : "" }}>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <label for="">Date of birth</label>
                                                <input type="date"  class="form-control" min="2000" name="dob" value="{{ $user->dob }}" required>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade  {{ $page == "bank" ? "show active" : "" }}" id="nav-bank" role="tabpanel" aria-labelledby="nav-bank-tab">
                                    <form action="{{ route("user.account.profile.bank") }}" method="post">@csrf
                                        <div class="form-row">
                                            <div class="col-md-12 mt-3">
                                                <label for="">Bank Name</label>
                                                <select type="text" class="form-control" name="bank_name" value="" required>
                                                    @foreach ($banks as $bank)
                                                        <option value="{{ $bank["code"] }}" {{ optional($user->bank)->bank_name == $bank["name"] ? "selected" : '' }}>{{ $bank["name"] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label for="">Account Name</label>
                                                <input type="text" class="form-control" name="account_name" value="{{ optional($user->bank)->account_name }}" required>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <label for="">Account Number</label>
                                                <input type="number" class="form-control" name="account_no" value="{{ optional($user->bank)->account_no }}" required>
                                            </div>
                                           
                                            <div class="col-12">
                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade   {{ $page == "password" ? "show active" : "" }}" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</section>

@stop
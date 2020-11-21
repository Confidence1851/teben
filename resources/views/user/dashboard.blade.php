@extends('web.layouts.app' , ['title' => 'My Dashboard' , 'activePage' => 'profile'])
@section('content')


<!-- breadcrum -->
<section class="w3l-skill-breadcrum">
    <div class="breadcrum">
      <div class="container">
        <p><a href="#">Dashboard</a></p>
      </div>
    </div>
  </section>
  <!-- //breadcrum -->

<section class="w3l-login">
  <div class="w3l-form-36-mian">
    <div class="container">
      <div class="row">
          <div class="offset-md-2 col-md-8">
            <div class="form-inner-cont mx-100">
                <div class="mt-md-5">
                    @include("admin.layout.flash_message")
                    <div class="row">
                        <div class="col-md-6 mb-4 select_role">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <img src="{{ $logo_img }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <div class="h5"><b>{{ $user->name }}</b></div>
                                        <div class="">
                                            <small>
                                                <b>Role:</b> {{ $user->role }}
                                                <b></b>
                                            </small>
                                        </div>
                                        <div class="">
                                            <small>
                                                <b>Member Since:</b> {{ $user->created_at }}
                                                <b></b>
                                            </small>
                                        </div>

                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-md-6 mb-4 select_role">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">
                                            <div class="bold m-2 h5">
                                               <b> Wallet Balance </b>  NGN{{ number_format($user->wallet) }}
                                            </div>
                                            <div class="d-flex">
                                                <button class="btn-success btn btn-sm m-2" data-toggle="modal" data-target="#account_deposit_modal"> Deposit</button> </p>
                                                <button class="btn-danger btn btn-sm m-2 " {{ $user->wallet < 1 ? "" : "" }} data-toggle="modal" data-target="#account_withdraw_modal"> Withdraw</button> </p>
                                                @include("user.fragments.modals.account_deposit_modal")
                                                @include("user.fragments.modals.account_withdraw_modal")
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-md-4 mb-4 select_role">
                            <div class="card p-4">
                                <b>Referral Code:</b> {{ $user->uuid }}
                            </div>
                        </div>

                        <div class="col-md-8 mb-4 select_role">
                            <div class="card p-4">
                                <b>Referral link:</b> {{ route("ref_invite" , $user->uuid) }}
                            </div>
                        </div>

                        @if ($user->ref_status != 1)
                            <div class="col-md-12 mb-4 select_role">
                                <div class="card p-4">
                                    <b>Activate your account:</b>
                                    <form action="{{ route("user.activate.referral") }}" method="post">@csrf
                                        <div class="form-row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    Kindly deposit up to NGN200 into your account and press the activate button!
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-success  btn-block">Activate</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif


                        <div class="col-md-4 mb-4 select_role">
                            <div class="card p-4">
                                <div class="text-center">
                                    <i class="fa fa-user fs-30"></i>
                                </div>
                                <div class="text-center">Notifications</div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4 select_role">
                            <div class="card p-4">
                                <div class="text-center">
                                    <i class="fa fa-user fs-30"></i>
                                </div>
                                <div class="text-center">My Videos</div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4 select_role">
                            <a href="{{ route('user.media.index' , "books") }}">
                                <div class="card p-4">
                                    <div class="text-center">
                                        <i class="fa fa-user fs-30"></i>
                                    </div>
                                    <div class="text-center">Books</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 mb-4 select_role">
                            <a href="{{ route('user.media.index' , "videos") }}">
                                <div class="card p-4">
                                    <div class="text-center">
                                        <i class="fa fa-user fs-30"></i>
                                    </div>
                                    <div class="text-center">Lesson Videos</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 mb-4 select_role">
                            <a href="{{ route("user.account.profile") }}">
                                <div class="card p-4">
                                <div class="text-center">
                                    <i class="fa fa-user fs-30"></i>
                                </div>
                                <div class="text-center">My Profile</div>
                            </div>
                            </a>
                        </div>

                        <div class="col-md-4 mb-4 select_role">
                            <a href="{{ route("user.referrals") }}">
                                <div class="card p-4">
                                    <div class="text-center">
                                        <i class="fa fa-user fs-30"></i>
                                    </div>
                                    <div class="text-center">Referral Tree</div>
                                </div>
                            </a>
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
@extends('web.layouts.app' , ['title' => 'My Referral Tree' , 'activePage' => 'profile'])
@section('content')


<!-- breadcrum -->
<section class="w3l-skill-breadcrum">
    <div class="breadcrum">
      <div class="container">
        <p><a href="{{ route('home') }}">Dashboard</a> &nbsp; / &nbsp; Referral Tree</p>
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

                    @if(auth()->id() == $user->id)
                        @php
                            $data = getUserRefData($user);
                        @endphp
                        <div class="p-3">
                            <div class="card p-3">
                                <h4 class="mb-3">My Referrals</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class=""><b>Total Earnings:</b> {{ $data["total_earns"] }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class=""><b>Direct Downlines:</b> {{ $data["direct_refs"] }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class=""><b>Indirect Downlines:</b> {{ $data["indirect_refs"] }}</div>
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class=""> Earning Progress</div>
                                        <div class="progress">
                                            <div class="progress-bar text-center" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:{{ $data["progress"] }}%">
                                                {{ $data["progress"] }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    @else
                        <h4 class="ml-3 mb-3">{{ $user->name }}`s Referrals</h4>
                    @endif

                    @foreach ($referrals as $referral)
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12 mb-2 select_role">
                                    <a href="#" data-toggle="modal" data-target="#referral_user_id{{ $referral->user->id }}">
                                        <div class="card p-2">
                                            <div class="text-center">
                                                <i class="fa fa-user fs-30"></i>
                                            </div>
                                            <div class="text-center">{{ optional($referral->user)->name }}</div>
                                        </div>
                                    </a>
                                </div>
                                @include("user.fragments.modals.referral_user_info" , ["referral" => $referral])
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                        @foreach ($referral->user->downlines as $ref)
                                            <div class="col-4 mb-2 select_role">
                                                <a href="#" data-toggle="modal" data-target="#referral_user_id{{ $ref->user->id }}">
                                                    <div class="card p-2">
                                                        <div class="text-center">
                                                            <i class="fa fa-user fs-30"></i>
                                                        </div>
                                                        <div class="text-center d-none d-md-block"><small>{{ optional($ref->user)->name }}</small></div>
                                                    </div>
                                                </a>
                                            </div>
                                            @include("user.fragments.modals.referral_user_info" , ["referral" => $ref])

                                        @endforeach
                                </div>
                            </div>

                        </div>
                        <hr>
                    @endforeach
                </div>
               
            </div>
      </div>

     
      
    </div>
  </div>
</section>

@stop
<!doctype html>
<html class="no-js" lang="en">
@php($user = Auth::User())
@php($states = \App\Http\Controllers\Controller::states())
@php($mynots = App\Models\Notification::where('user_id',$user->id))
@php($allnots = $mynots->orderby('created_at','desc')->get())
@php($unreadnots = $mynots->where('read_status',0)->count())
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Teben Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ $logo_img }}">
    <link rel="stylesheet" href="{{ $admin_source }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ $admin_source }}/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ $admin_source }}/css/themify-icons.css">
    <link rel="stylesheet" href="{{ $admin_source }}/css/metisMenu.css">
    <link rel="stylesheet" href="{{ $admin_source }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ $admin_source }}/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="{{ $admin_source }}/css/typography.css">
    <link rel="stylesheet" href="{{ $admin_source }}/css/default-css.css">
    <link rel="stylesheet" href="{{ $admin_source }}/css/styles.css">
    <link rel="stylesheet" href="{{ $admin_source }}/css/responsive.css">
    <!-- modernizr css -->
    <script src="{{ $admin_source }}/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        .moreinfo{
            padding-left: 5px;
            padding-right: 5px;
        }
        .required{
            color:red;
        }
        .logo{
            width:80px;
        }
        .logo-text{
            color:white;
            font-size:20px;
            margin-left:10px;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <!-- <div id="preloader">
            <div class="loader"></div>
        </div> -->
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="">
                    <a href="{{ url('/') }}"><img class="logo" src="{{ asset('public/logo.png') }}" alt="Logo" title="Logo" style="height:60px;width:50px"/></a> <span class="logo-text"> Dashboard </span>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu" style="margin-bottom:10vh">
                            <li class="active">
                                <a href="{{ route('home') }}"><i class="ti-dashboard"></i><span>dashboard</span></a>
                            </li>
                            <li>
                                 <a href="{{ route('available_books')}}" ><i class="fa fa-book"></i><span>Books and Videos</span></a>
                            </li>
                        @if($user->role == "Investor")
                            <li>
                                 <a href=""><i class="ti-question">?</i><span>Investment History</span></a>
                            </li>

                            <li>
                                 <a href="#" data-toggle="modal" data-target="#depositmodal"><i class="fa fa-inbox"></i><span>Deposit</span></a>
                            </li>

                            <li>
                                 <a href="{{ route('transactions') }}"><i class="fa fa-recycle"></i><span>Transactions</span></a>
                            </li>
                        @else
                            @if($user->role == "Parent")
                                <li>
                                     <a href="{{ route('homeschooling') }}"><i class="ti-home"></i><span>Home Schooling</span></a>
                                </li>
                                <li>
                                     <a href="{{ route('quicktutors') }}"><i class="fa fa-users"></i><span>Quick Tutors</span></a>
                                </li>
                            @endif

                            @if($user->role != "Student")
                            <li>
                                 <a href="{{ route('lessonrequests') }}"><i class="ti-question">?</i><span>Requests</span></a>
                            </li>
                            @endif

                            <hr>
                            <li>
                                 <a href="#" data-toggle="modal" data-target="#depositmodal"><i class="fa fa-inbox"></i><span>Deposit</span></a>
                            </li>
                            <li>
                                 <a href="{{ route('transactions') }}"><i class="fa fa-recycle"></i><span>Transactions</span></a>
                            </li>
                            <hr>
                            @if($user->role != "Student")
                                @if($user->sub_role == "Agent")
                                <li>
                                     <a href="{{ route('agent_area') }}"><i class="fa fa-user blue-text"></i><span>Agent Area</span></a>
                                </li>
                                @else
                                <li>
                                     <a href="{{ route('applyagent') }}"><i class="fa fa-user blue-text"></i><span>Become an Agent</span></a>
                                </li>
                                @endif
                            @endif

                            @if($user->role == "Teacher")
                            <li>
                                     <a href="{{ route('applyteacher') }}"><i class="fa fa-user purple-text"></i><span>Become a Teacher</span></a>
                                </li>
                                @if(empty($user->teacher))
                                <li>
                                     <a href="{{ route('applyteacher') }}"><i class="fa fa-user purple-text"></i><span>Become a Teacher</span></a>
                                </li>
                                @else
                                <li>
                                    <a> <i class="fa fa-user purple-text"></i><span>Teacher {{$user->teacher->status}}</span></a>
                                </li>
                                    @if($user->teacher->status == 'Approved')
                                        <li>
                                            <a href="{{ route('myinfo') }}"> <i class="fa fa-id white-text"></i><span>Download ID</span></a>
                                        </li>
                                    @endif
                                @endif
                            @endif
                        @endif
                           <li style="margin-bottom:10vh">
                                <a href="#" class="logoutbtn "> <i class="ti-alert"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf
                                </form>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->

        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-2 ">
                        <div class="nav-btn pull-left">
                             <b style="color:blue">Menu</b>
                        </div>

                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-10">
                        <ul class="notification-area pull-right">
                            <!-- <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li> -->
                            <li class="dropdown">
                                <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                                    <span>{{$unreadnots}}</span>
                                </i>
                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <span class="notify-title" style="font-size:13px">You have {{$unreadnots}} unread notifications</span>
                                    <div class="nofity-list">
                                        <div class="notify-content">
                                            @foreach($allnots as $not)
                                                @if($not->type == 'Password')
                                                    <a href="javascript:void(0)" class="notify-item">
                                                        <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                                        <div class="notify-text">
                                                            <p>{{$not->message}}</p>
                                                            <span>{{date('d M Y, h:i:A',strtotime($not->created_at))}}</span>
                                                        </div>
                                                    </a>
                                                @elseif($not->type == 'Request')
                                                    <a href="{{ route('lessonrequests') }}#{{$not->reference_id}}" class="notify-item">
                                                        <div class="notify-thumb"><i class="ti-user btn-success"></i></div>
                                                        <div class="notify-text">
                                                            <p>{{$not->message}}</p>
                                                            <span>{{date('d M Y, h:i:A',strtotime($not->created_at))}}</span>
                                                        </div>
                                                    </a>
                                                @elseif($not->type == 'Report')
                                                    <a href="{{ route('lessonrequests') }}#{{$not->reference_id}}" class="notify-item">
                                                    <div class="notify-thumb"><i class="ti-alert btn-warning"></i></div>
                                                    <div class="notify-text">
                                                        <p>{{$not->message}}</p>
                                                        <span>{{date('d M Y, h:i:A',strtotime($not->created_at))}}</span>
                                                    </div>
                                                </a>
                                                @else
                                                    <a href="javascript:void(0)" class="notify-item">
                                                    <div class="notify-thumb"><i class="ti-comment btn-primary"></i></div>
                                                    <div class="notify-text">
                                                        <p>{{$not->message}}</p>
                                                        <span>{{date('d M Y, h:i:A',strtotime($not->created_at))}}</span>
                                                    </div>
                                                </a>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="bottomcontent text-center" style="display:none">Loading....</div>
                                    </div>
                                </div>
                            </li>

                            <li class="settings-btn">
                               My Profile
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->

    @yield('content')


    <div class="offset-area">
        <div class="offset-close"><i class="ti-close"></i></div>
        <ul class="nav offset-menu-tab">
            <li><a class="active" data-toggle="tab" href="#activity">Profile</a></li>
            <li><a data-toggle="tab" href="#settings">Edit Profile</a></li>

        </ul>
        <div class="offset-content tab-content">
            <div id="activity" class="tab-pane fade in show active ">
                    <!--<div class="user-avatar-name">-->
                    <!--    @if(!empty($user->avatar))-->
                    <!--      <img class="user-avatar"  src="{{ asset('public/avatar_images/'.$user->avatar) }}" style="margin-left:30px;width:220px;height:225px" alt="avatar">-->
                    <!--    @else-->
                    <!--        <img class="user-avatar " src="{{ asset('public/user.png') }}" style="width:230px;margin-left:30px"alt="avatar">-->
                    <!--    @endif-->
                    <!--    <h6 class="text-center mt-2" id="username"><b>{{$user->name}}</b></h6>-->

                    <!--</div>-->
                <div class="settings-list"  style="padding-bottom:50px">
                <div class="recent-activity ">

                    <!--<div class="timeline-task">-->
                    <!--    <div class="icon bg2">-->
                    <!--        <i class="fa fa-money"></i>-->
                    <!--    </div>-->
                    <!--    <div class="tm-title">-->
                    <!--        <p><span value="{{$user->wallet}}" class="walletBal">{{$user->wallet}}</span> <span>-->
                    <!--        @if($user->role != "User")-->
                    <!--            <button class="btn-danger wthbtn" data-toggle="modal" data-target="#withdrawmodal"><i class="fa fa-arrow-up"></i> Withdraw</button></span> </p>-->
                    <!--        @endif-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="tm-title">
                            <p id="userUname">{{$user->username}}</p>
                        </div>
                    </div>
                    @if(!empty($user->email))
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <p id="useremail">{{$user->email}}</p>
                        </div>
                    </div>
                    @endif
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <p id="userphone">{{$user->phone}}</p>
                        </div>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="fa fa-bomb"></i>
                        </div>
                        <div class="tm-title">
                            <p>Role : {{$user->role}}</p>
                        </div>

                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="ti-signal"></i>
                        </div>
                        <div class="tm-title">
                            <p>Reg Date</p>
                            <p class="time mt-3 "><i class="ti-time"></i> {{date('D, d M Y - h:i:A',strtotime($user->created_at))}}</p>
                        </div>
                    </div>

                </div>
                </div>
            </div>
            <div id="settings" class="tab-pane fade">
                <div class="offset-settings">
                    <h4>Edit Profile</h4>
                    <div class="settings-list"  style="padding-bottom:40px">
                        <form action="{{ route('updateProfile') }}" method="post" enctype="multipart/form-data"> {{csrf_field()}}
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Change Picture</h5>
                                    <div class="s-swtich">
                                        <input type="file" class="form-control" name="image" id="comp_profile-image" />
                                    </div>
                                </div>
                            </div>
                            <div class="s-settings">
                                <div class="s-sw-title">
                                    <h5>Phone Number</h5>
                                    <div class="s-swtich">
                                        <input type="number" class="form-control" minlength="11" maxlength="11" placeholder="070000000000" name="phone" id="comp_profile-phone" value="{{$user->phone}}" required/>
                                    </div>
                                </div>
                            </div>

                            <div class="s-settings">
                                <p>Status</p>
                                <div class="s-sw-title">
                                    <select type="text" name="marital_status" id="comp_profile-marital_status" class="form-control"  style="height: 45px"  required>
                                        <option value="" disabled selected>Are you married ?</option>
                                        <option value="Married" {{$user->marital_status == "Married" ? 'selected' : ''}}>Married</option>
                                        <option value="Single" {{$user->marital_status == "Single" ? 'selected' : ''}}>Single</option>
                                        <option value="Divorced" {{$user->marital_status == "Divorced" ? 'selected' : ''}}>I`m divorced</option>
                                    </select>
                                </div>
                            </div>


                            <div class="s-settings">
                                    <p>I`m in ?</p>
                                <div class="s-sw-title">
                                    <select type="text" name="country" id="comp_profile-country" class="form-control fc" style="height: 45px" required>
                                        <option value="" disabled selected>Select Country</option>
                                        <option value="Nigeria" selected>Nigeria</option>
                                    </select>
                                </div>
                            </div>


                            <div class="s-settings">
                                <p>What state are you in ?</p>
                                <div class="s-sw-title">
                                    <select type="text" name="state" id="comp_profile-state" class="form-control" placeholder="Lagos"  style="height: 45px" required >
                                       <option value="" disabled selected>Select State</option>
                                       @foreach($states as $state)
                                            <option value="{{$state->name}}" {{$user->state == $state->name ? 'selected' : ''}} >{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="s-settings">
                                <p>Local government ?</p>
                                <div class="s-sw-title">
                                    <select type="text" name="lga" id="comp_profile-lga" class="form-control" required  style="height: 45px" placeholder="Ibeju Lekki">
                                    <option value="" disabled selected>Select L.G.A</option>
                                    @if(!empty($user->lga))
                                      <option value="{{$user->lga}}" selected >{{$user->lga}}</option>
                                    @endif
                                    </select>
                                </div>
                            </div>


                            <div class="s-settings">
                                    <p>Town ?</p>
                                <div class="s-sw-title">
                                    <input type="text" name="town" id="comp_profile-town" class="form-control" required placeholder="Bogije" value="{{$user->town}}">
                                </div>
                            </div>

                            <div class="s-settings">
                                <p>Address</p>
                                <div class="s-sw-title">
                                    <div class="s-swtich">
                                        <textarea type="text" rows="5" cols="80" id="comp_profile-address" class="form-control" name="address" required placeholder="House no. , street name, town, local gov area, state, country e.g 4,Akinyemi street, Bogije, Ibeju Lekki, Lagos, Nigeria. value="{{$user->address}}" placeholder="Enter your home address. e.g. Plot 4,Street name,Town name,State, Country" />{{$user->address}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="s-settings mb-4">
                                <button class="btn btn-primary form-control" type="submit">Save</button>
                            </div>
                        </form>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offset area end -->

           <!-- Vertically centered modal start -->

                                <!-- Modal -->
                                <div class="modal fade bd-example-modal-sm" id="depositmodal">
                                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Make Payment</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <form action="{{ route('couponRecharge') }}" method="post" enctype="multipart/form-data"> {{csrf_field()}}
                                                        <label>Use Coupon Code</label>
                                                        <input type="number" class="form-control" name="code" required>
                                                        <button type="submit" class="btn btn-success mt-2">Proceed</button>
                                                    </form>
                                                </div>
                                                <br>
                                                OR
                                                <br>
                                                <div class="text-center mb-4">
                                                    Kindly Make your payments to the account details below and upload a receipt below!
                                                </div>
                                                <p>Gurantee Trust Bank (GTB)</p>
                                                <p>0490382627</p>
                                                <p class="mb-1">Teben Educational Centre</p>
                                                <p>or</p>
                                                <p class="mb-1">Call +234 703 396 4406 for assitance</p>
                                            <form action="{{ route('uploadreceipt') }}" method="post" enctype="multipart/form-data"> {{csrf_field()}}
                                                <label>Upload payment receipt</label>
                                                <input type="file" class="form-control" name="image" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Proceed</button>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                    <!-- Vertically centered modal end -->



           <!-- Vertically centered modal start -->

                            @if($user->role != "User")
                                <!-- Modal -->
                                <div class="modal fade bd-example-modal-sm" id="withdrawmodal">
                                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Place Withdrawal</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center mb-3">
                                                    The withdrawal request would be processed on or before 28th of the month and the withdrawn amount would be sent to:
                                                </div>
                                                @php($bName = explode(',',$user->bank->bank_name))
                                                <p>Bank Name : <span class="fr">{{ $bName[1] }}</span></p>
                                                <p>Account Number : <span class="fr">{{$user->bank->account_no}}</span></p>
                                                <p>Account Name : <span class="fr">{{$user->bank->account_name}}</span></p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('withdraw') }}" method="post">{{csrf_field()}}
                                                    <button type="submit" class="btn btn-success">Proceed</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <!-- Vertically centered modal end -->
                    @endif

                    </div>
@if (Session::has('error_msg'))
    <p id="alert_error" style="display:none">{!! session('error_msg') !!}</p>
@endif
@if (Session::has('success_msg'))
    <p id="alert_success" style="display:none">{!! session('success_msg') !!}</p>
@endif
@if (Session::has('notify_msg'))
    <p id="notify_msg" style="display:none">{!! session('notify_msg') !!}</p>
@endif

<!-- The actual snackbar -->
<div id="snackbar"></div>
<!-- footer area start-->
<footer>
    <div class="footer-area">
        <p>© Copyright Teben tutors 2020. All right reserved.</p>
    </div>
</footer>
<!-- footer area end-->
</div>
<!-- page container area end -->
<!-- offset area start -->

    <!-- jquery latest version -->
    <script src="{{ $admin_source }}/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- <script src="{{ $admin_source }}/js/jquery-3.3.1.js"></script> -->
    <!-- bootstrap 4 js -->
    <script src="{{ $admin_source }}/js/popper.min.js"></script>
    <script src="{{ $admin_source }}/js/bootstrap.min.js"></script>
    <script src="{{ $admin_source }}/js/owl.carousel.min.js"></script>
    <script src="{{ $admin_source }}/js/metisMenu.min.js"></script>
    <script src="{{ $admin_source }}/js/jquery.slimscroll.min.js"></script>
    <script src="{{ $admin_source }}/js/jquery.slicknav.min.js"></script>



    <!-- others plugins -->
    <script src="{{ $admin_source }}/js/plugins.js"></script>
    <script src="{{ $admin_source }}/js/scripts.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>

</body>

</html>

<!--<div>-->
<!--                                                    <form action="{{ route('deposit') }}" method="post" id="depositform"> {{csrf_field()}}-->
<!--                                                        <label for="" class="">Enter amount in Naira (N)</label>-->
<!--                                                        <input type="hidden" name="ref" id="formRef">-->
<!--                                                        <input class="form-control mb-2"  style="border-radius:50px;height:35px;text-align:center" type="number" name="amount" id="depositamount" required>-->
<!--                                                        <div id="depositInfo" style="display: none">Amt: <span id="depositText"></span><span style="float: right" >Fee: <span id="depositFee"></span></span></div>-->
<!--                                                        <div class="text-center mt-3" id="depositMsg"></div>-->
<!--                                                </div>-->

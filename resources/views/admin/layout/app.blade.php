<!doctype html>
<html class="no-js" lang="en">
@php($user = auth()->User())

@php($mynots = App\Models\Notification::where('user_id',$user->id))
@php($allnots = $mynots->orderby('created_at','desc')->get())
@php($unreadnots = $mynots->where('read_status',0)->count())

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Teben Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ $admin_source }}/images/icon/favicon.ico">
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
        select{
            height: 46px !important;
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
                <div class="logo">
                    <a href="{{ url('/') }}"><img class="logo" src="{{ $logo_img }}" alt="Logo" title="Logo" height="100" width="100"/></a> <span class="logo-text"> Dashboard </span>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu" style="margin-bottom:10vh">
                            <li class="active">
                                <a href="{{ route('home') }}"><i class="ti-dashboard"></i><span>Dashboard</span></a>
                            </li>

                            <li class="">
                                <a href="{{ route('admin.schools.index') }}"><i class="ti-book"></i><span>Schools</span></a>
                            </li>

                            <li>
                                 <a href="{{ route('media.index')}}" ><i class="fa fa-book"></i><span>Books and Videos</span></a>
                            </li>

                            <li>
                                 <a href="{{ route('coupons.index') }}"><i class="ti-thumb-up"></i><span>Coupons</span></a>
                            </li>

                            <li>
                                 <a href="{{ route('users') }}"><i class="ti-user"></i><span>Users</span></a>
                            </li>

                             <li>
                                 <a href="{{ route('investors') }}"><i class="ti-face-smile"></i><span>Investors</span></a>
                            </li>

                            <li>
                                 <a href="{{ route('agents') }}"><i class="ti-thumb-up"></i><span>Agents</span></a>
                            </li>

                            <li>
                                 <a href="{{ route('requests') }}"><i class="ti-thumb-up"></i><span>Requests</span></a>
                            </li>

                             <li>
                                 <a href="{{ route('receipts') }}"><i class="ti-pencil-alt"></i><span>Receipts</span></a>
                            </li>

                            <li>
                                 <a href="{{ route('deposits') }}"><i class="ti-stats-down"></i><span>Deposits</span></a>
                            </li>

                            <li>
                                 <a href="{{ route('withdrawals') }}"><i class="ti-stats-up"></i><span>Withdrawals</span></a>
                            </li>

                            <li>
                                 <a href="#"><i class="fa fa-recycle"></i><span>Admin Transactions</span></a>
                            </li>

                            <hr>
                            <li>
                                 <a href="{{ route('teacherapply') }}"><i class="ti-server"></i><span>Teacher Applications</span></a>
                            </li>
                            <li>
                                 <a href="{{ route('agentsapply') }}"><i class="ti-people"></i><span>Agents Applications</span></a>
                            </li>
                            <hr>
                            <li style="margin-bottom:10vh">
                                 <a href="{{ route('logout') }}" class="logoutbtn"><i class="ti-server"></i><span>Logout</span></a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf
                            </form>
                            <br>
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
                            <span></span>
                            <span></span>
                            <span></span>
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
                                                    <a href="{{ route('requests') }}" class="notify-item">
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
                                @if(!empty($user->avatar))
                                    <img class="avatar user-thumb" src="{{ $admin_source }}/ges/'.$user->avatar) }}" alt="avatar">
                                @else
                                    <img class="avatar user-thumb" src="{{ $admin_source }}/ }}" alt="avatar">
                                @endif
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->

            <div class="row">
                <div class="col-sm-12">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                            </button>
                            <span>{{$error }}</span>
                    @endforeach
                </div>
            </div>

    @include('admin.layout.flash_message')
    @yield('content')


    <div class="offset-area">
        <div class="offset-close"><i class="ti-close"></i></div>
        <ul class="nav offset-menu-tab">
            <li><a class="active" data-toggle="tab" href="#activity">Profile</a></li>
            <li><a data-toggle="tab" href="#settings">Edit</a></li>

        </ul>
        <div class="offset-content tab-content">
            <div id="activity" class="tab-pane fade in show active">
                    <div class="user-avatar-name">
                        @if(!empty($user->avatar))
                          <img class="user-avatar"  src="{{ $admin_source }}/ges/'.$user->avatar) }}" style="margin-left:40px;width:200px" alt="avatar">
                        @else
                            <img class="user-avatar " src="{{ $admin_source }}/ }}" style="width:200px;margin-left:40px"alt="avatar">
                        @endif
                        <h6 class="text-center mt-2" id="username"><b>{{$user->name}}</b></h6>

                    </div>

                <div class="recent-activity">


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
            <div id="settings" class="tab-pane fade">
                <div class="offset-settings">
                    <h4>Edit Profile</h4>
                    <div class="settings-list">
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
                                       @foreach(getStates() as $state)
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

                            <div class="s-settings">
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
        <p>© Copyright 2018. All right reserved. Template by <a href="https://colorlib.com/wp/">Colorlib</a>.</p>
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
    <script src="{{ $admin_source }}/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="{{ $admin_source }}/js/scripts.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>

     <!-- Start datatable js -->
  <script src="{{ $admin_source }}/datatables/datatables.min.js"></script>
  <script src="{{ $admin_source }}/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{ $admin_source }}/jquery-ui/jquery-ui.min.js"></script>
  <script src="{{ $admin_source }}/datatables/js/page/datatables.js"></script>

</body>

</html>

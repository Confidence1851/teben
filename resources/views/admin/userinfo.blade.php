@extends('admin.layout.app')

@section('content')

    <!-- Main Content -->
    <div class="main-content container">
        <section class="section">
          <div class="section-body">
    
                <div class="card">
                  <div class="card-header">
                    <h4>{{$user->name}}`s Profile 
                      <span class="fr">
                        @if(!empty($user->teacher))
                            @if($user->teacher->status == 'Awaiting Approval')
                            <form action="{{ route('teacherstatus',$user->teacher->id) }}" method="post">{{ csrf_field() }}
                              <input type="hidden" name="stat" value="1">
                              <button class="btn btn-success" type="submit"> Approve application</button>
                            </form>
                            <form action="{{ route('rejectteacher',$user->teacher->id) }}" method="post">{{ csrf_field() }}
                              <button class="btn btn-danger" type="submit"> Reject </button>
                            </form>
                            @endif
                            @if($user->teacher->status == 'Teacher Approved')
                            <form action="{{ route('teacherstatus',$user->teacher->id) }}" method="post">{{ csrf_field() }}
                              <input type="hidden" name="stat" value="2">
                              <button class="btn btn-danger" type="submit"> Suspend Teacher</button>
                            </form>                            
                            @endif
                            @if($user->teacher->status == 'Teacher Suspended')
                            <form action="{{ route('teacherstatus',$user->teacher->id) }}" method="post">{{ csrf_field() }}
                              <input type="hidden" name="stat" value="3">
                              <button class="btn btn-primary" type="submit"> Re-approve Teacher</button>
                            </form>                            
                            @endif
                        @endif
                      </span>
                    </h4>
                  </div>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                            @if(!empty($user->avatar))
                                <img class="avatar" src="{{ asset('public/avatar_images/'.$user->avatar) }}" alt="avatar" style="width:100%">
                            @else
                                <img class="avatar" src="{{ asset('public/user.png') }}" alt="avatar">
                            @endif
                        </div>
                        <div class="col-md-4">
                          <p><b>ID :</b> <span class="moreinfo"> {{$user->uuid}}</span></p>
                          <p><i class="ti-email"></i> <span class="moreinfo"> {{$user->email}}</span></p>
                          <p><b>Phone :</b> <span class="moreinfo"> {{$user->phone}}</span></p>
                          <p><b>Role :</b> <span class="moreinfo"> {{$user->role}}</span></p>
                          <p><b>Status :</b> <span class="moreinfo"> {{$user->status}}</span></p>
                          <p><b>Reg Date :</b> <span class="moreinfo"> {{ date('d-m-Y',strtotime($user->created_at)) }}</span></p>
                          <p><b>Country :</b> <span class="moreinfo"> {{$user->country}}</span></p>
                          <p><b>State :</b> <span class="moreinfo"> {{$user->state}}</span></p>
                          <p><b>LGA :</b> <span class="moreinfo"> {{$user->lga}}</span></p>
                          <p><b>Town :</b> <span class="moreinfo"> {{$user->town}}</span></p>
                        </div>

                        @if($user->teacher != null)

                        <div class="col-md-4">
                          <h5 class="text-center">Bank Information</h5>
                          <p><b>Bank name :</b> <span class="moreinfo"> {{$user->bank->bank_name}}</span></p>
                          <p><b>Account Number :</b> <span class="moreinfo"> {{$user->bank->account_no}}</span></p>
                          <p><b>Account Name :</b> <span class="moreinfo"> {{$user->bank->account_name}}</span></p>

                          <div class="row mt-2">
                            <div class="col-md-12"><h5 class="text-center">Docs</h5></div>
                            <div class="col-4">
                              @if(!empty($user->teacher->passport))
                                <a href="" data-toggle="modal" data-target="#{{$user->teacher->passport}}">
                                  <img class="avatar" src="{{ asset('public/Passport_images/'.$user->teacher->passport) }}" alt="passport" style="width:100%">
                                </a>
                              @endif
                              @if(!empty($user->teacher->drivers_licence))
                                <a href="" data-toggle="modal" data-target="#$user->teacher->drivers_licence">
                                  <img class="avatar" src="{{ asset('public/Drv_images/'.$user->teacher->drivers_licence) }}" alt="avatar" style="width:100%">
                                </a>
                              @endif
                              @if(!empty($user->teacher->nin))
                                <a href="" data-toggle="modal" data-target="#$user->teacher->nin">
                                  <img class="avatar" src="{{ asset('public/Nin_images/'.$user->teacher->nin) }}" alt="avatar" style="width:100%">
                                </a>
                              @endif
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                            <h5 class="text-center">Teacher Information</h5>
                            @php($major = App\Models\Subject::where('id',$user->teacher->major)->first())
                            @php($sub1 = App\Models\Subject::where('id',$user->teacher->sub1)->first())
                            @php($sub2 = App\Models\Subject::where('id',$user->teacher->sub2)->first())
                            <p><b>Qualification :</b> <span class="moreinfo"> {{$user->teacher->qualification}}</span></p>
                            <p><b>Speciality :</b> <span class="moreinfo"> {{$user->teacher->specialty}}</span></p>
                            <p><b>Major Subject :</b> <span class="moreinfo"> {{ $major->name }}</span></p>
                            <p><b>Others :</b> <span class="moreinfo"> {{$sub1->name}}, {{$sub2->name}}</span></p>
                            <p><b>Yrs of Experience :</b> <span class="moreinfo"> {{$user->teacher->yrs_experience}}</span></p>
                          </div>
                        <div class="col-md-4">
                            <p><b>Language :</b> <span class="moreinfo"> {{$user->teacher->language}}</span></p>
                            <p><b>WorkPosition :</b> <span class="moreinfo"> {{$user->teacher->workposition}}</span></p>
                            <p><b>Work Place :</b> <span class="moreinfo"> {{$user->teacher->workplace}}</span></p>
                            <p><b>Work Address :</b> <span class="moreinfo"> {{$user->teacher->workaddress}}</span></p>
                            <p><b>Employee`s Phone :</b> <span class="moreinfo"> {{$user->teacher->emp_phone}}</span></p>
                          </div>
                        <div class="col-md-4">
                            <p><b>Jobs Completed :</b> <span class="moreinfo"> {{$user->teacher->jobs}}</span></p>
                          <p><b>Reports :</b> <span class="moreinfo"> {{$user->teacher->report}}</span></p>
                          <p><b>Status :</b> <span class="moreinfo"> {{$user->teacher->status}}</span></p>
                          <p><b>Next of Kin :</b> <span class="moreinfo"> {{$user->teacher->n_o_k}}</span></p>
                          <p><b>Relationship :</b> <span class="moreinfo"> {{$user->teacher->relationship}}</span></p>
                          <p><b>Next of Kin Phone :</b> <span class="moreinfo"> {{$user->teacher->phone_n_o_k}}</span></p>
                        </div>
                      </div>
                  

                               
                     
                <!--Info Modal -->
                @if(!empty($user->teacher->passport))
                  <div class="modal fade bd-example-modal-md" id="{{$user->teacher->passport}}">
                      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title">Passport</h5>
                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                              </div>
                              <div class="modal-body">
                                  <img class="avatar" src="{{ asset('Passport_images/'.$user->teacher->passport) }}" alt="avatar" style="width:100%">
                                      
                              </div>
                          </div>
                      </div>
                  </div>
                  @endif

                  @if(!empty($user->teacher->drivers_licence))
                  <div class="modal fade bd-example-modal-md" id="{{$user->teacher->drivers_licence}}">
                      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title">Passport</h5>
                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                              </div>
                              <div class="modal-body">
                                  <img class="avatar" src="{{ asset('Passport_images/'.$user->teacher->drivers_licence) }}" alt="avatar" style="width:100%">
                                      
                              </div>
                          </div>
                      </div>
                  </div>
                  @endif


                  @if(!empty($user->teacher->nin))
                  <div class="modal fade bd-example-modal-md" id="{{$user->teacher->nin}}">
                      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title">Passport</h5>
                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                              </div>
                              <div class="modal-body">
                                  <img class="avatar" src="{{ asset('Passport_images/'.$user->teacher->nin) }}" alt="avatar" style="width:100%">
                                      
                              </div>
                          </div>
                      </div>
                  </div>
                  @endif
                    <!-- Vertically centered modal end -->

                @endif


                </div>
                </div>
              </div>

              @if($user->role == 'Teacher')
                  <div class="row mt-2">
                    <div class="col-md-12">
                    <h5 class="text-center">Lesson Requests</h5>

                      @foreach($Myrequests as $request)
                        @php($teacher = App\Models\User::find($request->receiver_id))
                        @php($comments = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->get())
                        @php($Countcomments = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->count())
                        @php($reports = App\Models\Comment::where('transaction_id',$request->id)->where('type','reports')->get())
                        @php($Countreports = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->count())

                        <div class="col-md-4 card">
                          <a href="" data-toggle="modal" data-target="#requestmodal-{{$request->id}}">
                            <div class="col-md-12 mt-2 mb-3 text-center">{{$request->user->name}} {{$request->purpose}}</div>
                          </a>
                            <span><b>Amount: </b> NGN{{$request->amount}}</span>
                            <p><b>Status: </b>{{$request->status}} <span class="moreinfo fr"> {{ date('d-m-Y h:i:A',strtotime($request->created_at)) }}</span></p>
                        </div>

                          <!--Info Modal -->
                          <div class="modal fade bd-example-modal-md" id="requestmodal-{{$request->id}}">
                                      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title">Request Information</h5>
                                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                              </div>
                                              <div class="modal-body">
                                              <div class="row">
                                                  <div class="col-md-12 mb-3">{{$request->user->name}} {{$request->purpose}}</div>
                                                  <div class="col-md-6">
                                                      <p><b>ID :</b> <span class="moreinfo"> {{$request->uuid}}</span></p>
                                                      <p><b>Teacher :</b> <span class="moreinfo"> {{$teacher->name}}</span></p>
                                                      <p><b>Curriculum :</b> <span class="moreinfo"> {{$request->curriculum}}</span></p>
                                                      <p><b>Subject :</b> <span class="moreinfo"> {{$request->subject}}</span></p>
                                                      <p><b>Price :</b> <span class="moreinfo">NGN {{$request->amount}}</span></p>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <p><b>Duration :</b> <span class="moreinfo"> {{$request->duration}} Minutes</span></p>
                                                      <p><b>Status :</b> <span class="moreinfo"> {{$request->status}}</span></p>
                                                      <p><b>Schedule :</b> <span class="moreinfo"> {{ date('d-m-Y h:i:A',strtotime($request->schedule)) }}</span></p>
                                                      <p><b>Created on :</b> <span class="moreinfo"> {{ date('d-m-Y h:i:A',strtotime($request->created_at)) }}</span></p>
                                                  </div>
                                                  <div class="col-md-12">
                                                      <p><b>Reviews :</b> <span class="moreinfo" style="color:green">Comments( {{$Countcomments}} )</span> <span class="moreinfo" style="color:red">Reports( {{$Countreports}} )</span></p>
                                                  </div>
                                              </div>
                                              <div class="row">
                                                  @if($Countcomments > 0)
                                                      <div class=" col-md-12 text-center" style="color:green">Comments</div>
                                                          @foreach($comments as $comment)
                                                              <div class="col-md-12">
                                                                  <p>
                                                                  @if(!empty($user->avatar))
                                                                      <img class="avatar user-thumb" src="{{ asset('avatar_images/'.$user->avatar) }}" alt="avatar" style="width:100%">
                                                                  @else
                                                                      <img class="avatar user-thumb" src="{{ asset('user.png') }}" alt="avatar">
                                                                  @endif
                                                                  <b> {{$user->name}} said: </b><span class="moreinfo"> {{$comment->message}}</span></p>
                                                                  <p><span class="moreinfo" style="float:right"> {{ date('d-m-Y',strtotime($comment->created_at)) }}</span></p>
                                                              </div>
                                                          @endforeach
                                                      @endif

                                                      @if($Countreports > 0)
                                                          <div class=" col-md-12 text-center mt-2" style="color:red">Reports</div>
                                                          @foreach($reports as $comment)
                                                              <div class="col-md-12">
                                                                  <p>
                                                                  @if(!empty($user->avatar))
                                                                      <img class="avatar user-thumb" src="{{ asset('avatar_images/'.$user->avatar) }}" alt="avatar" style="width:100%">
                                                                  @else
                                                                      <img class="avatar user-thumb" src="{{ asset('user.png') }}" alt="avatar">
                                                                  @endif
                                                                  <b> {{$user->name}} said: </b><span class="moreinfo"> {{$comment->message}}</span></p>
                                                                  <p><span class="moreinfo" style="float:right"> {{ date('d-m-Y',strtotime($comment->created_at)) }}</span></p>
                                                              </div>
                                                          @endforeach
                                                      @endif
                                                      
                                                  </div>
                                                  
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                    @endforeach
                  </div>
                  @endif



                <div class="row mt-2">

                  <div class="col-md-4 mt-2">
                  <h5 class="text-center">Requests</h5>

                    @foreach($requests as $request)
                      @php($teacher = App\Models\User::find($request->receiver_id))
                      @php($comments = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->get())
                      @php($Countcomments = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->count())
                      @php($reports = App\Models\Comment::where('transaction_id',$request->id)->where('type','reports')->get())
                      @php($Countreports = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->count())

                      <div class="col-md-12 card">
                        <a href="" data-toggle="modal" data-target="#requestmodal-{{$request->id}}">
                          <div class="col-md-12 mt-2 mb-3 text-center">{{$request->user->name}} {{$request->purpose}}</div>
                        </a>
                          <span><b>Amount: </b> NGN{{$request->amount}}</span>
                          <p><b>Status: </b>{{$request->status}} <span class="moreinfo fr"> {{ date('d-m-Y h:i:A',strtotime($request->created_at)) }}</span></p>
                      </div>

                        <!--Info Modal -->
                        <div class="modal fade bd-example-modal-md" id="requestmodal-{{$request->id}}">
                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Request Information</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">{{$request->user->name}} {{$request->purpose}}</div>
                                                <div class="col-md-6">
                                                    <p><b>ID :</b> <span class="moreinfo"> {{$request->uuid}}</span></p>
                                                    <p><b>Teacher :</b> <span class="moreinfo"> {{$teacher->name}}</span></p>
                                                    <p><b>Curriculum :</b> <span class="moreinfo"> {{$request->curriculum}}</span></p>
                                                    <p><b>Subject :</b> <span class="moreinfo"> {{$request->subject}}</span></p>
                                                    <p><b>Price :</b> <span class="moreinfo">NGN {{$request->amount}}</span></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><b>Duration :</b> <span class="moreinfo"> {{$request->duration}} Minutes</span></p>
                                                    <p><b>Status :</b> <span class="moreinfo"> {{$request->status}}</span></p>
                                                    <p><b>Schedule :</b> <span class="moreinfo"> {{ date('d-m-Y h:i:A',strtotime($request->schedule)) }}</span></p>
                                                    <p><b>Created on :</b> <span class="moreinfo"> {{ date('d-m-Y h:i:A',strtotime($request->created_at)) }}</span></p>
                                                </div>
                                                <div class="col-md-12">
                                                    <p><b>Reviews :</b> <span class="moreinfo" style="color:green">Comments( {{$Countcomments}} )</span> <span class="moreinfo" style="color:red">Reports( {{$Countreports}} )</span></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @if($Countcomments > 0)
                                                    <div class=" col-md-12 text-center" style="color:green">Comments</div>
                                                        @foreach($comments as $comment)
                                                            <div class="col-md-12">
                                                                <p>
                                                                @if(!empty($user->avatar))
                                                                    <img class="avatar user-thumb" src="{{ asset('avatar_images/'.$user->avatar) }}" alt="avatar" style="width:100%">
                                                                @else
                                                                    <img class="avatar user-thumb" src="{{ asset('user.png') }}" alt="avatar">
                                                                @endif
                                                                <b> {{$user->name}} said: </b><span class="moreinfo"> {{$comment->message}}</span></p>
                                                                <p><span class="moreinfo" style="float:right"> {{ date('d-m-Y',strtotime($comment->created_at)) }}</span></p>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    @if($Countreports > 0)
                                                        <div class=" col-md-12 text-center mt-2" style="color:red">Reports</div>
                                                        @foreach($reports as $comment)
                                                            <div class="col-md-12">
                                                                <p>
                                                                @if(!empty($user->avatar))
                                                                    <img class="avatar user-thumb" src="{{ asset('avatar_images/'.$user->avatar) }}" alt="avatar" style="width:100%">
                                                                @else
                                                                    <img class="avatar user-thumb" src="{{ asset('user.png') }}" alt="avatar">
                                                                @endif
                                                                <b> {{$user->name}} said: </b><span class="moreinfo"> {{$comment->message}}</span></p>
                                                                <p><span class="moreinfo" style="float:right"> {{ date('d-m-Y',strtotime($comment->created_at)) }}</span></p>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                    @endforeach
                  </div>

                  <div class="col-md-4 mt-2">
                    <h5 class="text-center">Deposits</h5>

                      @foreach($deposits as $deposit)
                        
                        <div class="col-md-12 card">
                            <div class="col-md-12 mt-2 mb-3 text-center"> {{$deposit->purpose}}</div>
                            <span><b>Amount: </b> NGN{{$deposit->amount}}</span>
                            <p><b>Status: </b>{{$deposit->status}} <span class="moreinfo fr"> {{ date('d-m-Y h:i:A',strtotime($deposit->created_at)) }}</span></p>
                        </div>
                      @endforeach
                  </div>

                  <div class="col-md-4 mt-2">
                    <h5 class="text-center">Withdrawals</h5>

                      @foreach($withdrawals as $withdrawal)
                        
                        <div class="col-md-12 card">
                            <div class="col-md-12 mt-2 mb-3 text-center"> {{$withdrawal->purpose}}</div>
                            <span><b>Amount: </b> NGN{{$withdrawal->amount}}</span>
                            <p><b>Status: </b>{{$withdrawal->status}} <span class="moreinfo fr"> {{ date('d-m-Y h:i:A',strtotime($withdrawal->created_at)) }}</span></p>
                        </div>
                      @endforeach
                  </div>

                </div>

                
        </section>
    </div>

 <!-- JS Libraies -->
  <script src="dashboard/datatables/datatables.min.js"></script>
  <script src="dashboard/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="dashboard/jquery-ui/jquery-ui.min.js"></script>

@endsection
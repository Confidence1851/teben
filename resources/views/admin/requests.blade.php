@extends('admin.layout.app')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-body">
    
                <div class="card">
                  <div class="card-header">
                    <h4>Lesson Requests</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>Action</th>
                            <th class="text-center">ID</th>
                            <th>Parent</th>
                            <th>Subject</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Teacher</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $request)
                            @php($teacher = App\Models\User::find($request->receiver_id))
                            @php($comments = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->get())
                            @php($Countcomments = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->count())
                            @php($reports = App\Models\Comment::where('transaction_id',$request->id)->where('type','reports')->get())
                            @php($Countreports = App\Models\Comment::where('transaction_id',$request->id)->where('type','comment')->count())
                            
                            @php($major = App\Models\Subject::where('id',$request->subject)->first())
                          <tr>
                             <td class="align-middle"><a href="#" data-toggle="modal" data-target="#requestmodal-{{$request->id}}" class="btn btn-primary">Details</a></td>
                            <td class="align-middle">#{{$request->uuid}}</td>
                            <td class="align-middle"><a href="" data-toggle="modal" data-target="#usermodal-{{$request->user->id}}">{{$request->user->name}}</a></td>
                            <td class="align-middle">{{ $major->name }}</td>
                            <td class="align-middle">{{ date('d-m-Y h:i:A',strtotime($request->schedule)) }}</td>
                            <td class="align-middle">{{$request->status}}</td>
                            <td class="align-middle"><a href=""  data-toggle="modal" data-target="#usermodal-{{$teacher->id}}">{{$teacher->name}}</a></td>
                          </tr>

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
                                                <div class="col-md-12 mb-3"> {{$request->purpose}}</div>
                                                <div class="col-md-6">
                                                    <p><b>ID :</b> <span class="moreinfo"> {{$request->uuid}}</span></p>
                                                    <p><b>Parent :</b> <span class="moreinfo"> {{$request->user->name}} </span></p>
                                                    <p><b>Teacher :</b> <span class="moreinfo"> {{$teacher->name}}</span></p>
                                                    <p><b>Curriculum :</b> <span class="moreinfo"> {{$request->curriculum}}</span></p>
                                                    <p><b>Subject :</b> <span class="moreinfo"> {{ $major->name }} </span></p>
                                                    <p><b>Price :</b> <span class="moreinfo"> {{$request->amount}}</span></p>
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
                                                                    <img class="avatar user-thumb" src="{{ asset('public/avatar_images/'.$user->avatar) }}" alt="avatar" style="width:100%">
                                                                @else
                                                                    <img class="avatar user-thumb" src="{{ asset('public/user.png') }}" alt="avatar">
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

                    <!-- Vertically centered modal end -->
                    
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
                            @foreach($users as $user)
                                <!--Info Modal -->
                                <div class="modal fade bd-example-modal-md" id="usermodal-{{$user->id}}">
                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{$user->name}}`s Profile</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    @if(!empty($user->avatar))
                                                        <img class="avatar" src="{{ asset('public/avatar_images/'.$user->avatar) }}" alt="avatar" style="width:100%">
                                                    @else
                                                        <img class="avatar" src="{{ asset('publi/user.png') }}" alt="avatar">
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <p><b>ID :</b> <span class="moreinfo"> {{$user->uuid}}</span></p>
                                                    <p><i class="ti-email"></i> <span class="moreinfo"> {{$user->email}}</span></p>
                                                    <p><b>Phone :</b> <span class="moreinfo"> {{$user->phone}}</span></p>
                                                    <p><b>Role :</b> <span class="moreinfo"> {{$user->role}}</span></p>
                                                    <p><b>Status :</b> <span class="moreinfo"> {{$user->status}}</span></p>
                                                    <p><b>Reg Date :</b> <span class="moreinfo"> {{ date('d-m-Y',strtotime($user->created_at)) }}</span></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                    <div class="col-md-6">
                                                        <p><b>Country :</b> <span class="moreinfo"> {{$user->country}}</span></p>
                                                        <p><b>State :</b> <span class="moreinfo"> {{$user->state}}</span></p>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><b>LGA :</b> <span class="moreinfo"> {{$user->lga}}</span></p>
                                                        <p><b>Town :</b> <span class="moreinfo"> {{$user->town}}</span></p>
                                                        
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p><b>Address :</b> <span class="moreinfo"> {{$user->address}}</span></p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <span class="fr"><a href="{{ route('userinfo',$user->id) }}" class="btn btn-primary">Go to Profile</a></span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
        </section>
    </div>

 <!-- JS Libraies -->
  <script src="dashboard/datatables/datatables.min.js"></script>
  <script src="dashboard/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="dashboard/jquery-ui/jquery-ui.min.js"></script>

@endsection
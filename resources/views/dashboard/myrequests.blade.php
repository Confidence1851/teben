@extends('dashboard.layout.app')

@section('content')
        <!-- main content area start -->
        <ul class="breadcrumb">
           <li class="moreinfo"><i class="fa fa-home moreinfo"></i>Home</li> /
           <li class="moreinfo"><i class="fa fa-dashboard moreinfo"></i>Dashboard</li> /
           <li class="moreinfo"><i class="fa fa-question moreinfo"></i>Requests</li> 
        </ul>
            <div class="main-content-inner">
                <h4>Lesson Requests!</h4>
            
                <div class="row mt-4">
                    @foreach($requests as $tran)
                    @php($user = Auth::user())
                    @php($teacher = App\Models\User::find($tran->receiver_id))
                    @php($subject = App\Models\Subject::find($tran->subject))
                    <div class="col-md-4 mb-3" id="{{$tran->id}}">
                        <div class="card" style="padding:10px">
                        <div class="text-center mb-2">{{$tran->purpose}} for {{$subject->name}}</div>
                            <p style="font-size:13px">Duration: {{$tran->duration}}minutes <span style="float:right;"> Time: {{date('d M Y, h:i:A',strtotime($tran->schedule))}}</span></p>
                            <p style="font-size:13px">Teacher: <a href="">{{$teacher->name}}</a> <span style="float:right;"> Status: {{$tran->status}}</span></p>

                            <p>
                                @if($tran->status == 'Pending')
                                    @if($tran->user_id != $user->id)
                                        @if($tran->receiver_id == $user->id) 
                                        <span class="tbtns">
                                            <form action="{{ route('tranResponse',$tran->id) }}" method="post">{{ csrf_field() }}
                                                <input type="hidden" name="option" value="Accepted">
                                                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-check"></i> Accept</button>
                                            </form>
                                        </span>
                                        <span class="tbtns" >
                                            <form action="{{ route('teacherstatus',$tran->id) }}" method="post">{{ csrf_field() }}
                                                <input type="hidden" name="option" value="Rejected">
                                                <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i> Reject</button>
                                            </form>
                                            
                                            <!-- <a href="" class="btn btn-success btn-sm acceptbtn" id="1"><i class="fa fa-check"></i> Accept</a>
                                            <a href="" class="btn btn-danger btn-sm rejectbtn" ><i class="fa fa-trash"></i> Reject</a> -->
                                        </span>
                                        @endif
                                    @else
                                    <span class="tbtns" style="float:right;">
                                            <form action="{{ route('tranResponse',$tran->id) }}" method="post">{{ csrf_field() }}
                                                <input type="hidden" name="option" value="Cancelled">
                                                <button class="btn btn-warning btn-sm fr" type="submit"><i class="fa fa-trash"></i> Cancel</button>
                                                <a href="" class="btn btn-danger btn-sm reportbtn " data-toggle="modal" data-target="#mymodal" ><i class="fa fa-warning"></i> Report</a>
                                            </form>
                                            
                                        <!-- <a href="" class="btn btn-warning btn-sm cancelbtn" ><i class="fa fa-trash"></i> Cancel</a> -->
                                    </span>
                                    @endif
                                @else
                                    <a href="#{{$tran->id}}" class="btn btn-sm btn-block text-center" style="font-size:13px;height:35px">Response Date: {{date('d-m-Y, h:i:A',strtotime($tran->updated_at))}}</a>
                                @endif

                                <p style="font-size:13px">ID #{{$tran->uuid}} <span style="float:right;">{{date('d-m-Y, h:i:A',strtotime($tran->created_at))}}</span></p>
                            </p>
                        </div>
                    </div>

                    <div class="modal fade" id="mymodal" data-backdrop="static">
                        <div class="modal-dialog modal-dialog-md modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Lay a complaint</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('tranComment',$tran->id) }}" method="post">{{ csrf_field() }}
                                    <div class="form-group">
                                        <p>Please describe the situation in the best possible way!</p>
                                        <input type="hidden" name="type" value="Report">
                                        <textarea name="message" id=""  rows="10" class="form-control" autofocus required placeholder="Enter you complain here...">{{old('message')}}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Proceed</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    @endforeach

                </div>

            </div>
        <!-- main content area end -->

@endsection
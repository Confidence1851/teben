@extends('admin.layout.app')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-body">
    
                <div class="card">
                  <div class="card-header">
                    <h4>Agents
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Bought</th>
                            <th>Sold</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($agents as $agent)
                        @php($bought = App\Models\Coupon::where('agent_id',$agent->id)->count())
                        @php($sold = App\Models\Coupon::where('agent_id',$agent->id)->where('user_id','')->count())
                          <tr>
                            <td class="align-middle">
                                @if(!empty($agent->user->avatar))
                                    <img class="avatar user-thumb" src="{{ asset('public/avatar_images/'.$agent->user->avatar) }}" alt="avatar">
                                @else
                                    <img class="avatar user-thumb" src="{{ asset('public/user.png') }}" alt="avatar">
                                @endif
                            </td>
                            <td class="align-middle">{{$agent->user->name}}</td>
                            <td class="align-middle">{{$agent->user->email}}</td>
                            <td class="align-middle">{{$bought}}</td>
                            <td class="align-middle">{{$sold}}</td>
                            <td class="align-middle"><a href="#" data-toggle="modal" data-target="#usermodal-{{$agent->id}}" class="btn btn-sm btn-primary">Details</a></td>
                          </tr>

                                <!--Info Modal -->
                                <div class="modal fade bd-example-modal-md" id="usermodal-{{$agent->id}}">
                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{$agent->user->name}}`s Profile</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    @if(!empty($agent->user->avatar))
                                                        <img class="avatar" src="{{ asset('public/avatar_images/'.$agent->user->avatar) }}" alt="avatar" style="width:100%">
                                                    @else
                                                        <img class="avatar" src="{{ asset('public/user.png') }}" alt="avatar">
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <p><b>ID :</b> <span class="moreinfo"> {{$agent->user->uuid}}</span></p>
                                                    <p><i class="ti-email"></i> <span class="moreinfo"> {{$agent->user->email}}</span></p>
                                                    <p><b>Phone :</b> <span class="moreinfo"> {{$agent->user->phone}}</span></p>
                                                    <p><b>Role :</b> <span class="moreinfo"> {{$agent->user->role}}</span></p>
                                                    <p><b>Status :</b> <span class="moreinfo"> {{$agent->status}}</span></p>
                                                    <p><b>Reg Date :</b> <span class="moreinfo"> {{ date('d-m-Y',strtotime($agent->created_at)) }}</span></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                    <div class="col-md-6">
                                                        <p><b>Country :</b> <span class="moreinfo"> {{$agent->user->country}}</span></p>
                                                        <p><b>State :</b> <span class="moreinfo"> {{$agent->user->state}}</span></p>
                                                        
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><b>LGA :</b> <span class="moreinfo"> {{$agent->user->lga}}</span></p>
                                                        <p><b>Town :</b> <span class="moreinfo"> {{$agent->user->town}}</span></p>
                                                        
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p><b>Address :</b> <span class="moreinfo"> {{$agent->user->address}}</span></p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <span class="fr"><a href="{{ route('agent_coupons',$agent->id) }}" class="btn btn-primary">See Coupons</a></span>
                                                    </div>
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
           
        </section>
    </div>

   <!-- Start datatable js -->
  <script src="{{asset('public/dashboard/datatables/datatables.min.js') }}"></script>
  <script src="{{asset('public/dashboard/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{asset('public/dashboard/jquery-ui/jquery-ui.min.js') }}"></script>

@endsection
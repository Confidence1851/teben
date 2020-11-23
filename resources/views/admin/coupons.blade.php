@extends('admin.layout.app')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-body">

                <div class="card">
                  <div class="card-header">
                    <h4>Coupon Codes
                    <span style="float:right"> <button class="btn-sm btn-outline-primary" data-toggle="modal" data-target="#addcoupon">Add Coupons</button> </span>
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">Info</th>
                            <th>Code</th>
                            <th>Amount</th>
                            <th>Agent</th>
                            <th>Used By</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons as $coupon)
                          <tr>
                            <td class="align-middle"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#viewmodal-{{$coupon->id}}" >View</a></td>
                            <td class="align-middle">{{$coupon->code}}</td>
                            <td class="align-middle">NGN {{$coupon->amount}}</td>
                            <td class="align-middle">{{$coupon->agent->name }}</td>
                            @if(empty($coupon->user_id) && empty($coupon->school_account_id))
                                <td class="align-middle">Not yet</td>
                            @else
                                <td class="align-middle">{{optional($coupon->user)->name}}</td>
                            @endif
                            <td>
                                @if(empty($coupon->user_id) && empty($coupon->school_account_id))
                                <form action="{{ route('coupons.destroy',$coupon->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this item?');">@csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @else
                                    <button type="button" class="btn btn-sm btn-success">Used</button>
                                @endif
                            </td>
                          </tr>




                    <!-- Vertically centered modal end -->


                                 <!--Info Modal -->
                                 <div class="modal fade bd-example-modal-md" id="viewmodal-{{$coupon->id}}">
                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Coupon info</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><b>Created at:</b> {{ date('D, M d Y h:i:a',strtotime($coupon->created_at)) }}</p>
                                                @if(!empty($coupon->user_id))
                                                    <p><b>Used By:</b> {{ $coupon->user->name }}</p>
                                                    <p><b>Used On:</b> {{ date('D, M d Y h:i:a',strtotime($coupon->updated_at)) }}</p>
                                                @elseif(!empty($coupon->school_account_id))
                                                    <p><b>Used By School Account:</b> {{ $coupon->school_account->name }}</p>
                                                    <p><b>Used On:</b> {{ date('D, M d Y h:i:a',strtotime($coupon->updated_at)) }}</p>
                                                @else
                                                    <p><b>Used By:</b> Not yet </p>
                                                @endif

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
            <!--Add coupon Modal -->
            <div class="modal fade bd-example-modal-md" id="addcoupon">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">New Coupons</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('coupons.store') }}">@csrf
                                <div class="form-group">
                                    <label>Coupon Agent</label>
                                    <select class="form-control" required name="agent_id" style="height:45px">
                                        <option disabled selected>Select Agent</option>
                                        <!--<option value="{{Auth::user()->id}}">Myself (Admin)</option>-->
                                        @foreach($agents as $agent)
                                            <option value="{{$agent->id}}"> {{ $agent->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Coupon Price</label>
                                    <select class="form-control" required name="amount" style="height:45px" >
                                        <option disabled selected>Select Price</option>
                                        <option value="100">NGN100</option>
                                        <option value="200">NGN200</option>
                                        <option value="500">NGN500</option>
                                        <!--<option value="1000">NGN500</option>-->
                                        <!--<option value="2000">NGN500</option>-->
                                        <!--<option value="5000">NGN500</option>-->
                                        <!--<option value="10000">NGN500</option>-->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Quantity</label>
                                    <select class="form-control" name="quantity" style="height:45px" aria-required="true">
                                        <option disabled selected>Select Quantity</option>
                                        <option value="1">1 Coupon</option>
                                        <option value="2">2 Coupons</option>
                                        <option value="5">5 Coupons</option>
                                        <option value="10">10 Coupons</option>
                                        <option value="20">20 Coupons</option>
                                        <option value="50">50 Coupons</option>
                                        <option value="100">100 Coupons</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary">Proceed</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

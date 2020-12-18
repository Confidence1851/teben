@extends('admin.layout.app')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-body">
    
                <div class="card">
                  <div class="card-header">
                    <h4>Payment Receipts</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>Image</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($receipts as $receipt)
                          <tr>
                             <td class="align-middle"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#viewmodal-{{$receipt->id}}" >View Receipt</a></td>
                             <td class="align-middle">{{$receipt->user->name}}</td>
                            <td class="align-middle">{{$receipt->amount}}</td>
                            <td class="align-middle">{{$receipt->type}}</td>
                            <td class="align-middle">{{$receipt->status}}</td>
                            @if($receipt->status == "Pending")
                                <td class="align-middle">{{$receipt->status}}</td>
                                <td class="align-middle"><a href="#" class="btn btn-success" data-toggle="modal" data-target="#editmodal-{{$receipt->id}}" ><i class="fa fa-edit"></i>Edit</a></td>

                            @else
                                @php($admin = App\Models\User::find($receipt->admin_id))
                                <td class="align-middle">{{$admin->name}}</td>
                                <td class="align-middle"><a href="#" class="btn btn-success"> Approved</a></td>
                            @endif
                          </tr>

                                 <!--Info Modal -->
                                 <div class="modal fade bd-example-modal-md" id="editmodal-{{$receipt->id}}">
                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit {{$receipt->user->name}}`s Account</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <form action="{{route('receiptdeposit',$receipt->id)}}" method="post">{{csrf_field()}}
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Amount</label>
                                                            <input class="form-control" type="number" name="amount" value="" placeholder="Enter amount" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <div>
                                                                <span class="fr"><button type="submit" class="btn btn-primary">Save</button></span>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                         
                    <!-- Vertically centered modal end -->
                    
                    
                                 <!--Info Modal -->
                                 <div class="modal fade bd-example-modal-md" id="viewmodal-{{$receipt->id}}">
                                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Receipt Image</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                               <img src="{{ asset('public/receipt_images/'.$receipt->image) }}" alt="receipt image">
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
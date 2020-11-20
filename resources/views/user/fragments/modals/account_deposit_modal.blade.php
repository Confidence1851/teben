@auth
    <!-- Modal -->
<div class="modal fade bd-example-modal-md" id="account_deposit_modal">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Make Payment</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form action="{{ route("user.account.deposit") }}" method="post" enctype="multipart/form-data"> {{csrf_field()}}
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
            <form action="{{ route("user.account.deposit")  }}" method="post" enctype="multipart/form-data"> {{csrf_field()}}
                <label>Upload payment receipt</label>
                <input type="file" class="form-control" name="receipt" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Proceed</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endauth
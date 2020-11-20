<!-- Modal -->
<div class="modal fade bd-example-modal-md" id="account_withdraw_modal">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Place Withdrawal</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    The withdrawal request would be processed on or before 28th of the month and the withdrawn amount would be sent to:
                </div>
                {{-- @php($bName = explode(',',optional($user->bank)->bank_name)) --}}
                <p>Bank Name : <span class="fr">{{ optional($user->bank)->bank_name ?? "N/A"}}</span></p>
                <p>Account Number : <span class="fr">{{optional($user->bank)->account_no ?? "N/A"}}</span></p>
                <p>Account Name : <span class="fr">{{optional($user->bank)->account_name ?? "N/A"}}</span></p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('withdraw') }}" method="post">{{csrf_field()}}
                    <button type="submit" class="btn btn-success">Proceed</button>
                </form>
            </div>
        </div>
    </div>
</div>
 @if (!empty($referral && !empty($user = $referral->user))) 
 <!--Download in progress Modal -->
 <div class="modal fade bd-example-modal-md" id="referral_user_id{{ $user->id }}">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="m-5">
                <div class="name"><b>Name:</b> {{ $user->name }}</div>
                <div class="name"><b>Referred By:</b> {{ optional($referral->upline)->name }}</div>
                <div class="name"><b>Referred on:</b> {{ $referral->created_at }}</div>
            </div>
            <div class="modal-footer">
                <div class="form-row">
                    <div class="col-auto fr">
                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-info" >Ok</button>
                    </div>
                    <div class="col-auto fr">
                        <a href="{{ route("user.referrals" , $referral->user_id) }}"  class="btn btn-sm btn-success" >View Downlines</a>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>
 @endif
  
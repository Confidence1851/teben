@if (!empty($media))
    <div class="modal fade bd-example-modal-md downloading_media_modal_parent" id="download_media_{{ $medium->id }}">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="m-5">
                    <div class="text-center">
                        Downloading this "{{ $medium->title }}"" may cost you some money! 
                    </div>
                
                </div>
                <div class="modal-footer">
                    <div class="form-row">
                        <div class="col-auto fr">
                            <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger" >Cancel</button>
                        </div>
                        <div class="col-auto fr">
                            <form action="{{ route('user.media.download') }}" method="post" class="downloading_media">@csrf
                                <input type="hidden" name="media_id" value="{{$medium->id}}" required>
                                <button type="submit" class="btn btn-sm btn-success text-white" >Download</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
@endif

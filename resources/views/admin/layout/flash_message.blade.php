@if (session('success_msg'))
<div class="row">
  <div class="col-sm-12">
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="material-icons">close</i>
      </button>
      <span>{{ session('success_msg') }}</span>
    </div>
  </div>
</div>
@endif

@if (session('error_msg'))
<div class="row">
  <div class="col-sm-12">
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="material-icons">close</i>
      </button>
      <span>{{ session('error_msg') }}</span>
    </div>
  </div>
</div>
@endif

<div class="row">
    <div class="col-sm-12">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
                </button>
                <span>{{$error }}</span>
      </div>
      @endforeach
  </div>
</div>

@extends('web.layouts.app' , ['title' => 'My Dashboard' , 'activePage' => 'profile'])
@section('content')


<!-- breadcrum -->
<section class="w3l-skill-breadcrum">
    <div class="breadcrum">
      <div class="container">
        <p><a href="{{ route('home') }}">Dashboard</a> &nbsp; / &nbsp; {{ $title ?? 'Media' }}</p>
      </div>
    </div>
  </section>
  <!-- //breadcrum -->

<section class="w3l-login">
  <div class="w3l-form-36-mian">
    <div class="container">
      <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="form-inner-cont mx-100">
                    @include("admin.layout.flash_message")
                    <div class="row">
                        <div class="col-md-2 h4"><b>{{ $title ?? '' }}</b></div>
                        <div class="col-md-10">
                            <form action="{{ $url ?? '' }}" >
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="keyword" value="{{ $requestData['keyword'] ?? ''  }}" placeholder="Search subject or title">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select  name="class" class="form-control" >
                                                <option value="" disabled selected> Select Class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}" {{ $class->id == $requestData['class'] ?? '' ? 'selected' : '' }}>{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select  name="term" class="form-control" >
                                                <option value="" disabled selected> Select Term</option>
                                                @foreach ($terms as $key => $value)
                                                    <option value="{{ $key }}" {{ $key == $requestData['term'] ?? '' ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-md">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="media_playlist">
                        @foreach ($media as $medium)
                            <div class="row mt-2" data-target="#download_media{{ $medium->id }}" data-toggle="modal">
                            <div class="col-md-2">
                                <img src="{{ getFileFromStorage($medium->getCoverImage() , "storage") }}" class="img-fluid" height="50" alt="">
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-12 h5">{{ $medium->title }}</div>
                                    <div class="col-auto">
                                        <small>
                                            <b>Subject:</b>
                                            {{ optional($medium->subject)->name }}
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <small>
                                            <b>Class:</b>
                                            {{ optional($medium->klass)->name }}
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <small>
                                            <b>Level:</b>
                                            {{ getLevels($medium->level) ?? $medium->level }}
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <small>
                                            <b>Term:</b>
                                            {{ getTerms($medium->term) }}
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <small>
                                            <b>Size:</b>
                                            {{ $medium->size }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <hr>
                            <!--Download Modal -->
                            <div class="modal fade bd-example-modal-md downloading_media_modal_parent" id="download_media{{ $medium->id }}">
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="m-5">
                                            <div class="text-center">
                                                Downloading this {{strtolower( $medium->attachment_type) }} may cost you some money! 
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
                        @endforeach
                    </div>
                    
                </div>
                <div class="text-center">
                    {{ $media->appends($requestData ?? '')->links() }}
                </div>
            </div>
      </div>

       <!--Download in progress Modal -->
       <div class="modal fade bd-example-modal-md" id="download_media_progress">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="m-5">
                    <div class="text-center">
                        Downloading in progress.....
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <div class="form-row">
                        <div class="col-auto fr">
                            <button type="button" data-dismiss="modal" class="btn btn-sm btn-info" >Ok</button>
                        </div>
                        
                    </div>
                </div>
            </div>
           
        </div>
    </div>
      
    </div>
  </div>
</section>

@stop
@extends('web.layouts.app' , ['title' => 'Media' , 'activePage' => 'media'])
@section('style')
<link rel="stylesheet" href="https://cdn.plyr.io/3.6.3/plyr.css" />
@endsection
@section('content')
<!-- breadcrum -->
<section class="w3l-skill-breadcrum">
  <div class="breadcrum">
    <div class="container">
      <p><a href="index.html">Home</a> &nbsp; / &nbsp; Courses</p>
    </div>
  </div>
</section>


<section class="w3l-offered-courses">
  <div class="container pb-lg-5">
    @include("admin.layout.flash_message")

    <div class="row mt-3">
      <div class="col-md-9">
        <video src="{{ asset("video.mp4") }}" controls class="img-fluid" id="video_player" ></video>
      </div>
      <div class="col-md-3">
        inof
      </div>
    </div>

    <div class="sticky-top comments-head ">
      <h5 class="mt-3 mb-2">Comments from viewers</h5>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div id="comments-list">
            <div class="comment-item mt-2 mb-1">
              <b>Confidence says:</b>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eius doloremque dicta esse tempora hic odit ex unde, quas aut facilis commodi maxime veniam quo magni dignissimos in aliquam ipsam?</span>
              <br>
              <small>12/12/2020</small>
              <hr>
            </div>
            <div class="comment-item mt-2 mb-1">
              <b>Confidence says:</b>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eius doloremque dicta esse tempora hic odit ex unde, quas aut facilis commodi maxime veniam quo magni dignissimos in aliquam ipsam?</span>
              <br>
              <small>12/12/2020</small>
              <hr>
            </div>
            <div class="comment-item mt-2 mb-1">
              <b>Confidence says:</b>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eius doloremque dicta esse tempora hic odit ex unde, quas aut facilis commodi maxime veniam quo magni dignissimos in aliquam ipsam?</span>
              <br>
              <small>12/12/2020</small>
              <hr>
            </div>
            <div class="comment-item mt-2 mb-1">
              <b>Confidence says:</b>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eius doloremque dicta esse tempora hic odit ex unde, quas aut facilis commodi maxime veniam quo magni dignissimos in aliquam ipsam?</span>
              <br>
              <small>12/12/2020</small>
              <hr>
            </div>
            <div class="comment-item mt-2 mb-1">
              <b>Confidence says:</b>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eius doloremque dicta esse tempora hic odit ex unde, quas aut facilis commodi maxime veniam quo magni dignissimos in aliquam ipsam?</span>
              <br>
              <small>12/12/2020</small>
              <hr>
            </div>
            <div class="comment-item mt-2 mb-1">
              <b>Confidence says:</b>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eius doloremque dicta esse tempora hic odit ex unde, quas aut facilis commodi maxime veniam quo magni dignissimos in aliquam ipsam?</span>
              <br>
              <small>12/12/2020</small>
              <hr>
            </div>
            <div class="comment-item mt-2 mb-1">
              <b>Confidence says:</b>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eius doloremque dicta esse tempora hic odit ex unde, quas aut facilis commodi maxime veniam quo magni dignissimos in aliquam ipsam?</span>
              <br>
              <small>12/12/2020</small>
              <hr>
            </div>
            <div class="comment-item mt-2 mb-1">
              <b>Confidence says:</b>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis eius doloremque dicta esse tempora hic odit ex unde, quas aut facilis commodi maxime veniam quo magni dignissimos in aliquam ipsam?</span>
              <br>
              <small>12/12/2020</small>
              <hr>
            </div>
        </div>
        <div class="comment-form mt-3">
          <form action="" method="post">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Enter your name....." required>
            </div>
           <div class="form-group">
              <textarea name="" id="" cols="30" rows="4" placeholder="Type tour comment..." required class="form-control"></textarea>
           </div>
           <button type="submit" class="btn btn-primary btn-md">Comment</button>
          </form>
        </div>
      </div>
      <div class="col-md-3">
        
    </div>
    </div>

  </div>
</section>

<div style="margin: 8px auto; display: block; text-align:center;">
  <!---728x90--->
</div>
@stop
@section('script')
<script src="https://cdn.plyr.io/3.6.3/plyr.js"></script>
<script>
    const player = new Plyr('#video_player' , {
        controls: [
            'play-large', // The large play button in the center
            'restart', // Restart playback
            'rewind', // Rewind by the seek time (default 10 seconds)
            'play', // Play/pause playback
            'fast-forward', // Fast forward by the seek time (default 10 seconds)
            'progress', // The progress bar and scrubber for playback and buffering
            'current-time', // The current time of playback
            'duration', // The full duration of the media
            'mute', // Toggle mute
            'volume', // Volume control
            'captions', // Toggle captions
            'settings', // Settings menu
            'pip', // Picture-in-picture (currently Safari only)
            'airplay', // Airplay (currently Safari only)
            'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
            'fullscreen', // Toggle fullscreen
        ],
        urls: {
            download: '',
        },
    });

</script>
@endsection
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
                    @if ($mediaItem->isVIdeo())
                        <video src="{{ $mediaItem->getAttachment(false) }}" controls
                            class="img-fluid" id="video_player"></video>
                    @else
                        <div class="img-fluid mediaItem_bg_image"
                            style="background-image: url({{ $mediaItem->getCoverImageUrl() }})"
                            title="{{ $mediaItem->title }}"></div>
                    @endif
                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-start">
                        <div class="">
                            <img src="{{ $mediaItem->author->getAvatar() }}" class="img-fluid rounded-circle" width="60" title="Author"
                                alt="author image">
                        </div>
                        <div class="pt-2 ml-3">
                            <div class=""><b>Author</b></div>
                            <a href="#url">{{ $mediaItem->author->name }}</a>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-2">
                        @if (auth()->check())
                            <button class="btn btn-block btn-primary text-white"
                                data-target="#download_media_{{ $mediaItem->id }}" data-toggle="modal"
                                style="cursor: pointer" title="Download {{ $mediaItem->title }}">
                                Download for free
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-block btn-primary text-white">
                                Login to download
                            </a>
                        @endif
                    </div>
                    <div class="mb-2">
                        <b>Description : </b>
                        {{ $mediaItem->description }}
                    </div>
                    <div class="mb-2">
                        <b>Downloads : </b>
                        {{ $mediaItem->downloads_count }}
                    </div>
                    <div class="mb-2">
                        <b>Views : </b>
                        {{ $mediaItem->views_count }}
                    </div>
                    <div class="mb-2">
                        <b>Comments : </b>
                        {{ $mediaItem->comments_count }}
                    </div>
                    <div class="mb-2">
                        <b>Likes : </b>
                        {{ $mediaItem->likes_count }}
                    </div>
                    <div class="mb-2">
                        <b>Last updated : </b>
                        {{ date('M d, Y', strtotime($mediaItem->updated_at)) }}
                    </div>
                </div>
            </div>

            @if ($mediaItem->comments->count() > 0)
                <div class="sticky-top comments-head ">
                    <h6 class="mt-3 mb-2">Comments</h6>
                </div>
            @endif

            <div class="row">
                <div class="col-md-9">
                    @if ($mediaItem->comments->count() > 0)

                        <div id="comments-list">
                            @foreach ($mediaItem->comments as $comment)
                                <div class="comment-item mt-2 mb-1">
                                    <b>{{ $comment->name }} says:</b>
                                    <span>
                                        {{ $comment->comment }}
                                    </span>
                                    <br>
                                    <small>{{ $comment->created_at }}</small>
                                    <hr>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center m-5">Leave a comment</div>
                    @endif

                    <div class="comment-form mt-3">
                        <form action="{{ route('media_collection.comment') }}" method="post"> @csrf
                            @if (!auth()->check())
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="Enter your name....."
                                        required>
                                </div>
                            @endif
                            <input type="hidden" class="form-control" name="media_id" value="{{ $mediaItem->id }}" required>
                            <div class="form-group">
                                <textarea name="comment" id="" cols="30" rows="4" placeholder="Type your comment..."
                                    required class="form-control"></textarea>
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
    @include("user.fragments.modals.download_media" , ["mediaItem" => $mediaItem])
@stop
@section('script')
    <script src="https://cdn.plyr.io/3.6.3/plyr.js"></script>
    <script>
        const player = new Plyr('#video_player', {
            controls: [
                'play-large', // The large play button in the center
                'restart', // Restart playback
                // 'rewind', // Rewind by the seek time (default 10 seconds)
                'play', // Play/pause playback
                // 'fast-forward', // Fast forward by the seek time (default 10 seconds)
                'progress', // The progress bar and scrubber for playback and buffering
                'current-time', // The current time of playback
                'duration', // The full duration of the media
                // 'mute', // Toggle mute
                'volume', // Volume control
                // 'captions', // Toggle captions
                'settings', // Settings menu
                // 'pip', // Picture-in-picture (currently Safari only)
                'airplay', // Airplay (currently Safari only)
                // 'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
                'fullscreen', // Toggle fullscreen
            ],
            urls: {
                download: '',
            },
        });

    </script>
@endsection

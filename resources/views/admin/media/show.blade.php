@extends('admin.layout.app')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">



                <div class="card">
                    <div class="card-header">
                        <h4>Media Information
                            <span style="float:right"> <button class="btn-sm btn-outline-primary" data-toggle="modal"
                                    data-target="#editMedia">Edit Media</button> </span>
                        </h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            @if (Session::has('success'))
                                <div class="alert alert-success  btn-block">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert alert-danger  btn-block">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                        </div>



                        <div class="card-header row mb-3">
                            <div class="col-md-6 text-center">
                                <img src="{{ getFileFromStorage($mediaItem->getCoverImage(), 'storage') }}" alt="Cover Image"
                                    width="100%" height="100px" />
                            </div>
                            <div class="col-md-6 mt-2 mt-md-3">
                                <div class="h4"><b>{{ $mediaItem->title }}</b></div>
                                <div class="mb-2">
                                    <b>Media Type:</b> {{ $mediaItem->attachment_type }}
                                </div>
                                <div class="mb-2">
                                    <b>File Size:</b> {{ $mediaItem->size }}
                                </div>
                                <div class="mb-2">
                                    <b>Level:</b> {{ getLevels($mediaItem->level) ?? $mediaItem->level }}
                                </div>
                                <div class="mb-2">
                                    <b>Class:</b> {{ $mediaItem->klass->name ?? '' }}
                                </div>
                                <div class="mb-2">
                                    <b>Term:</b> {{ getTerms($mediaItem->term) }}
                                </div>

                                <div class="mb-2">
                                    <b>Subject:</b> {{ $mediaItem->subject->name }}
                                </div>
                                <div class="mb-3">
                                    <b>Price:</b> {{ $mediaItem->getPrice() }}
                                </div>
                                <div class="mb-3">
                                    <b>Status:</b>
                                    <span class="{{ $mediaItem->status == 1 ? 'text-success' : 'text-danger' }}">
                                        {{ $mediaItem->getStatus() }}
                                    </span>
                                </div>
                                <div class="">
                                    <form action="{{ route('download_attachment') }}" method="post"
                                        onsubmit="return confirm('Are you sure you want to download this item?');">@csrf
                                        @if ($mediaItem->attachment_type == 'Video')
                                            <a href="#" class="btn btn-sm btn-success" data-toggle="modal"
                                                data-target="#watchVideo">Watch</a>
                                        @endif
                                        <input type="hidden" name="filename" value="{{ $mediaItem->getAttachment() }}" required>
                                        <input type="hidden" name="name" value="{{ $mediaItem->title }}" required>
                                        <button type="submit" class="btn btn-sm btn-primary">Download</button>
                                    </form>
                                </div>

                            </div>
                            <div class="mt-3 offset-10 col-2">
                                <form action="{{ route('media.destroy', $mediaItem->id) }}" method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this item?');">@csrf
                                    @method('delete')
                                    <input type="hidden" name="coupon_id" value="{{ $mediaItem->id }}" required>
                                    <button type="submit" class="btn btn-sm btn-danger" style="float:right">Delete</button>
                                </form>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
    </div>

    <!--Add coupon Modal -->
    @if ($mediaItem->attachment_type == 'Video')
        <div class="modal fade bd-example-modal-md" id="watchVideo">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Watch Video</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body row">
                        <video class="col-12" width="100%" height="320" controls>
                            <source src="{{ route('watch_video_attachment', encrypt($mediaItem->getAttachment())) }}"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade bd-example-modal-md" id="editMedia">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Media</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('media.update', $mediaItem->id) }}" enctype="multipart/form-data">@csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Book or video title"
                                        value="{{ $mediaItem->title }}" required />
                                    @error('title')
                                        <p class="" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Level</label>
                                    <select class="form-control" name="level" style="height:45px" aria-required="true">
                                        <option disabled selected>Select One</option>
                                        @foreach ($levels as $key => $value)
                                            <option value="{{ $key }}" {{ $mediaItem->level == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('level')
                                        <p class="" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Class</label>
                                    <select class="form-control" name="klass_id" style="height:45px" aria-required="true">
                                        <option disabled selected>Select One</option>
                                        @foreach ($klasses as $klass)
                                            <option value="{{ $klass->id }}"
                                                {{ $mediaItem->klass_id == $klass->id ? 'selected' : '' }}>{{ $klass->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('klass_id')
                                        <p class="" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>Term</label>
                                    <select class="form-control" name="term" style="height:45px" aria-required="true">
                                        <option disabled selected>Select One</option>
                                        @foreach ($terms as $key => $value)
                                            <option value="{{ $key }}" {{ $mediaItem->term == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('term')
                                        <p class="" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Subject</label>
                                    <select class="form-control" name="subject_id" style="height:45px" aria-required="true">
                                        <option disabled selected>Select One</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ $mediaItem->subject_id == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <p class="" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cover Image</label>
                                    <input type="file" class="form-control" name="image" />
                                    @error('image')
                                        <p class="" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Download Price</label>
                                    <input type="number" class="form-control" name="price" placeholder="Price per download"
                                        value="{{ $mediaItem->price }}" required />
                                    @error('price')
                                        <p class="" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Book or Video</label>
                                    <input type="file" class="form-control" name="attachment" />
                                    @error('attachment')
                                        <p class="" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                    <p>Only upload Pdf , Docx , MP3 , Mp4 files not greater than 200MB</p>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" style="height:45px" aria-required="true">
                                        <option disabled selected>Select One</option>
                                        @foreach ($statuses as $key => $value)
                                            <option value="{{ $key }}" {{ $mediaItem->status == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>



                            </div>

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

@extends('web.layouts.app' , ['title' => 'Media' , 'activePage' => 'media'])

@section('content')
    <!-- breadcrum -->
    <section class="w3l-skill-breadcrum">
        <div class="breadcrum">
            <div class="container">
                <p><a href="index.html">Home</a> &nbsp; / &nbsp; Media Factory</p>
            </div>
        </div>
    </section>

    @php
    $isEdit = !empty($mediaItem->id);
    @endphp


    <section class="w3l-offered-courses">
        <div class="container pb-lg-5">
            @include("admin.layout.flash_message")
            @if ($user->refStatusActive())
                <h4 class="mt-3 mb-4">
                    {{ $isEdit ? 'Edit Your ' . $mediaItem->attachment_type : 'Make Something Interesting' }}</h4>

                <form method="post" action="{{ route('media_collection.factory.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $mediaItem->id }}">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Book or video title"
                                value="{{ $mediaItem->title }}" required />
                            @error('title')
                                <p class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label>Description</label>
                            <textarea rows="3" name="description" class="form-control" placeholder="Book or video title"
                                value="{{ $mediaItem->title }}" required>{!!  $mediaItem->description !!}</textarea>
                            @error('title')
                                <p class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>Level</label>
                            <select class="form-control" name="level" style="height:45px" required>
                                <option disabled selected>Select One</option>
                                @foreach ($levels as $key => $value)
                                    <option value="{{ $key }}" {{ $mediaItem->level == $key ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                            @error('level')
                                <p class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label>Class</label>
                            <select class="form-control" name="klass_id" style="height:45px" required>
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


                        <div class="form-group col-md-3">
                            <label>Term</label>
                            <select class="form-control" name="term" style="height:45px" required>
                                <option disabled selected>Select One</option>
                                @foreach ($terms as $key => $value)
                                    <option value="{{ $key }}" {{ $mediaItem->term == $key ? 'selected' : '' }}>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('term')
                                <p class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label>Subject</label>
                            <select class="form-control" name="subject_id" style="height:45px" required>
                                <option disabled selected>Select One</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ $mediaItem->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <p class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                        </div>


                        <div class="form-group col-md-3">
                            <label>Cover Image</label>
                            <input type="file" class="form-control" name="image" {{ $isEdit ? '' : 'required' }} />
                            @error('image')
                                <p class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-md-5">
                            <label>Book or Video</label>
                            <input type="file" class="form-control" name="attachment" {{ $isEdit ? '' : 'required' }} />
                            @error('attachment')
                                <p class="" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                            @enderror
                            <small>Only upload Pdf , Docx , MP3 , Mp4 files not greater than 200MB</small>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <select class="form-control" name="status" style="height:45px" required>
                                <option disabled selected>Select One</option>
                                <option value="Visible" {{ $mediaItem->status == 'Visible' ? 'selected' : '' }}>Visible
                                </option>
                                <option value="Hidden" {{ $mediaItem->status == 'Hidden' ? 'selected' : '' }}>Hidden
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-lg btn-primary">Proceed</button>
                        </div>


                    </div>


                </form>

        </div>
    @else
        <div class="text-center m-5">
            <h4 class="p-3">
                Activate your account to create or modify a book or video!
            </h4>
            <a href="{{ route('home') }}" class="btn btn-primary text-white">Go to dashboard</a>

        </div>
        @endif
        </div>
    </section>

    <div style="margin: 8px auto; display: block; text-align:center;">
        <!---728x90--->
    </div>
@stop

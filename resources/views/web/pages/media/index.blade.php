@extends('web.layouts.app' , ['title' => 'Media' , 'activePage' => 'media'])
@section('content')
    <!-- breadcrum -->
    <section class="w3l-skill-breadcrum">
        <div class="breadcrum">
            <div class="container">
                <p><a href="index.html">Home</a> &nbsp; / &nbsp; Courses</p>
            </div>
        </div>
    </section>
    <!-- //breadcrum -->

    <div style="margin: 8px auto; display: block; text-align:center;">
        <!---728x90--->

    </div>

    <section class="w3l-offered-courses">
        <div class="blog py-5" id="blog">
            <div class="container pb-lg-5">
                @include("admin.layout.flash_message")
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ $url ?? '' }}">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="keyword"
                                            value="{{ $requestData['keyword'] ?? '' }}"
                                            placeholder="Search subject or title">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="class" class="form-control">
                                            <option value="" disabled selected> Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ $class->id == $requestData['class'] ?? '' ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="term" class="form-control">
                                            <option value="" disabled selected> Select Term</option>
                                            @foreach ($terms as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ $key == $requestData['term'] ?? '' ? 'selected' : '' }}>{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-md">Filter</button>
                                    </div>
                                </div>
                                @if (auth()->check())
                                    <div class="col-auto">
                                        <div class="form-group">
                                            <a href="{{ route('media_collection.factory') }}"
                                                class="btn btn-primary btn-md">
                                                New Video
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">

                    @foreach ($media as $mediaItem)
                        <div class="col-lg-4 col-md-6 item">
                            <div class="card">
                                <div class="card-header p-0 position-relative">
                                    <a href="{{ $mediaItem->getDetailLink() }}" class="zoom d-block">
                                        <img class="card-img-bottom d-block" src="{{ $mediaItem->getCoverImageUrl() }}"
                                            title="{{ $mediaItem->title }}" alt="Media Image" />
                                    </a>
                                    <div class="author">
                                        <div class="author-image">
                                            <img src="{{ $media->user->getAvatar() }}"
                                                class="img-fluid rounded-circle" title="Author" alt="author image">
                                        </div>
                                        <div class="course-title">
                                            <a href="#url">{{ optional($mediaItem->subject)->name }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body course-details">
                                    <div class="price-review d-flex justify-content-between mb-1align-items-center">
                                        <p>
                                            <a href="{{ $mediaItem->getDetailLink() }}">
                                                {{ $mediaItem->title }}
                                            </a>
                                        </p>
                                    </div>
                                    At vero eos et accusam et uo dolores
                                </div>
                                <div class="card-footer course-price-view">
                                    <ul class="blog-list">
                                        <li>
                                            <a href="#url" title="Likes"><span class="fa fa-heart"></span> 98</a>
                                        </li>
                                        <li>
                                            <a href="#url" title="Downloads"
                                                data-target="#download_media_{{ $mediaItem->id }}" data-toggle="modal"
                                                style="cursor: pointer" title="Download {{ $mediaItem->title }}">
                                                <span class="fa fa-download"></span> 15
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#url" title="Views"><span title="Views" class="fa fa-eye"></span> 15</a>
                                        </li>
                                        <li>
                                            <a href="#url" title="Comments"><span class="fa fa-comment"></span> 15</a>
                                        </li>
                                        @if (canModifyMedia('edit', $mediaItem->user_id))
                                            <li>
                                                <a href="{{ $mediaItem->getEditLink() }}" title="Edit this item"> <span
                                                        class="fa fa-edit"></span> Edit</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @include("user.fragments.modals.download_media" , ["media" => $mediaItem])
                    @endforeach



                </div>

                <ul class="pagination mt-5 justify-content-center">
                    {!! $media->withQueryString()->links('vendor.pagination.custom') !!}
                </ul>
            </div>
        </div>
    </section>

    <div style="margin: 8px auto; display: block; text-align:center;">
        <!---728x90--->
    </div>
@stop

@extends('admin.layout.app')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">


                <div class="card">
                    <div class="card-header">
                        <h4>Manage Books and Videos
                            <span style="float:right"> <button class="btn-sm btn-outline-primary" data-toggle="modal"
                                    data-target="#addcoupon">Add Media</button> </span>
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

                        <form action="{{ route('media.index') }}" method="get">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input class="form-control" type="text" name="search_keywords"
                                        placeholder="Search for something" value="{{ $query['search_keywords'] ?? '' }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <input class="form-control" type="date" name="fromDate"
                                        value="{{ $query['fromDate'] ?? '' }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <input class="form-control" type="date" name="toDate"
                                        value="{{ $query['toDate'] ?? '' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" type="date" name="author">
                                        <option value="" selected>Select Author</option>
                                        <option value="admin"
                                            {{ !empty(($key = $query['author'] ?? '')) && $key == 'admin' ? 'selected' : '' }}>
                                            Admin</option>
                                        <option value="others"
                                            {{ !empty(($key = $query['author'] ?? '')) && $key == 'others' ? 'selected' : '' }}>
                                            Others</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" type="date" name="type">
                                        <option value="" selected>Select Type</option>
                                        <option value="video"
                                            {{ !empty(($key = $query['type'] ?? '')) && $key == 'video' ? 'selected' : '' }}>
                                            Video</option>
                                        <option value="book"
                                            {{ !empty(($key = $query['type'] ?? '')) && $key == 'book' ? 'selected' : '' }}>
                                            Book</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" type="date" name="subject">
                                        <option value="" selected>Select Subject</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}"
                                                {{ !empty(($key = $query['subject'] ?? '')) && $key == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" type="date" name="class">
                                        <option value="" selected>Select Class</option>
                                        @foreach ($klasses as $klass)
                                            <option value="{{ $klass->id }}"
                                                {{ !empty(($key = $query['class'] ?? '')) && $key == $klass->id ? 'selected' : '' }}>
                                                {{ $klass->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" type="date" name="level">
                                        <option value="" selected>Select Level</option>
                                        @foreach ($levels as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ !empty(($key = $query['level'] ?? '')) && $key == $key ? 'selected' : '' }}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" type="date" name="term">
                                        <option value="" selected>Select Term</option>
                                        @foreach ($terms as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ !empty(($key = $query['term'] ?? '')) && $key == $key ? 'selected' : '' }}>
                                                {{ $value }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <button class="btn btn-dark btn-block">Filter</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped" id="">
                                <thead>
                                    <tr>
                                        <th class="text-center">Cover</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Level</th>
                                        <th>Subject</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($media as $mediaItem)
                                        <tr>
                                            <td class="align-middle text-center"><img
                                                    src="{{ getFileFromStorage($mediaItem->getCoverImage(), 'storage') }}"
                                                    alt="Cover Image" width="50px" /></td>
                                            <td class="align-middle">{{ $mediaItem->title }}</td>
                                            <td class="align-middle">{{ optional($mediaItem->author)->name }}</td>
                                            <td class="align-middle">{{ getLevels($mediaItem->level) ?? $mediaItem->level }}
                                            </td>
                                            <td class="align-middle">{{ $mediaItem->subject->name ?? '' }}</td>
                                            <td class="align-middle">{{ $mediaItem->attachment_type }}</td>
                                            <td class="align-middle">{{ $mediaItem->size }}</td>
                                            <td class="align-middle">
                                                {{ $mediaItem->getPrice() }}
                                            </td>
                                            <td class="align-middle {{ $mediaItem->status == 1 ? "text-success" : "text-danger" }}">{{ $mediaItem->getStatus() }}</td>

                                            <td>
                                                <a href="{{ route('media.show', $mediaItem->id) }}"
                                                    class="btn btn-success btn-xs">View</a>
                                            </td>
                                        </tr>




                                        <!-- Vertically centered modal end -->


                                        <!--Info Modal -->
                                        <div class="modal fade bd-example-modal-md" id="viewmodal-{{ $mediaItem->id }}">
                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Coupon info</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span>&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><b>Created at:</b>
                                                            {{ date('D, M d Y h:i:a', strtotime($mediaItem->created_at)) }}
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Vertically centered modal end -->

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                {!! $media->links() !!}
            </div>
            <!--Add coupon Modal -->
            <div class="modal fade bd-example-modal-lg" id="addcoupon">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">New Media</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">

                            <form method="post" action="{{ route('media.store') }}" enctype="multipart/form-data">@csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Book or video title" required />
                                            @error('title')
                                                <p class="" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Level</label>
                                            <select class="form-control" name="level" style="height:45px"
                                                aria-required="true">
                                                <option disabled selected>Select One</option>
                                                @foreach ($levels as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
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
                                            <select class="form-control" name="klass_id" style="height:45px"
                                                aria-required="true">
                                                <option disabled selected>Select One</option>
                                                @foreach ($klasses as $klass)
                                                    <option value="{{ $klass->id }}">{{ $klass->name }}</option>
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
                                            <select class="form-control" name="term" style="height:45px"
                                                aria-required="true">
                                                <option disabled selected>Select One</option>
                                                @foreach ($terms as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
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
                                            <select class="form-control" name="subject_id" style="height:45px"
                                                aria-required="true">
                                                <option disabled selected>Select One</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
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
                                            <label>Download Price</label>
                                            <input type="number" class="form-control" name="price"
                                                placeholder="Price per download" required />
                                            @error('price')
                                                <p class="" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Cover Image</label>
                                            <input type="file" class="form-control" name="image" required />
                                            @error('image')
                                                <p class="" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                            @enderror
                                        </div>


                                        <div class="form-group">
                                            <label>Book or Video</label>
                                            <input type="file" class="form-control" name="attachment" required />
                                            @error('attachment')
                                                <p class="" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </p>
                                            @enderror
                                            <p>Only upload Pdf , Docx , Mp4 files not greater than 200MB</p>
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="status" style="height:45px"
                                                aria-required="true">
                                                <option disabled selected>Select One</option>
                                                @foreach ($statuses as $key => $value)
                                                <option value="{{ $key }}">
                                                    {{ $value }} </option>
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

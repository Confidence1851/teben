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
      <div class="row">
       
        @foreach ($media as $medium)
        <div class="col-lg-4 col-md-6 item">
          <div class="card">
            <div class="card-header p-0 position-relative">
              <a href="#url" class="zoom d-block">
                <img class="card-img-bottom d-block" src="{{ $web_source }}/images/g3.jpg" alt="Card image cap">
              </a>
              <div class="author">
                <div class="author-image">
                  <img src="{{ $web_source }}/images/student3.jpg" class="img-fluid rounded-circle" title="Adam Ster" alt="author image">
                </div>
                <div class="course-title">
                  <a href="#url">{{ optional($medium->subject)->name }}</a>
                </div>
              </div>
            </div>
            <div class="card-body course-details">
              <div class="price-review d-flex justify-content-between mb-1align-items-center">
                <p>{{ $medium->title }}</p>
              </div>
              <a href="#url" class="course-desc">At vero eos et accusam et
                justo uo dolores</a>
            </div>
            <div class="card-footer course-price-view">
              <ul class="blog-list">
                <li>
                  <a href="#url"><span class="fa fa-heart"></span> 98</a>
                </li>
                <li>
                  <a href="#url"><span class="fa fa-user"></span> 15</a>
                </li>
                <li>
                  <a href="#url"><span class="fa fa-download"></span> 15</a>
                </li>
                <li>
                  <a href="#url"><span class="fa fa-eye"></span> 15</a>
                </li>
                <li class="">
                  <a href="#url" class="reviews d-inline-block">(56 Reviews)</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        @endforeach

       
      
      </div>

      <ul class="pagination mt-5 justify-content-center">
        <li class="page-item">
        </li>
        <li class="page-item">
            <a class="page-link" href="#url"> <span class="fa fa-angle-double-left"></span></a>
        </li>
        <li class="page-item">
            <a class="page-link active" href="#url">1</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#url">2</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#url">3</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="#url"> <span class="fa fa-angle-double-right"></span></a>
        </li>
        <div class="clear"></div>
    </ul>

    </div>
  </div>
</section>

<div style="margin: 8px auto; display: block; text-align:center;">
  <!---728x90--->
</div>
@stop
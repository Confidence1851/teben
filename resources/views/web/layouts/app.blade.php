<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Teben Tutors">
    <meta name="keywords" content="teen tutor,tutor jobs, teben,tebentutors,teben tutors,tutors,lessons,home lesson,private lesson, children, education, teachers, hire teacher,tutorials">
    <meta name="author" content="Confidence Ugolo">
    <title>{{ $title ?? '' }} - Teben Tutors</title>

    <link href="http://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ $web_source }}/css/style-liberty.css">
    <style>
      .selected{
          color: #ff8f07 !important;
          border-width: 2px;
          border-color: #ff8f07 !important;
      }
  
      .select_role{
          cursor: pointer;
      }
  
      .w3l-login .form-inner-cont {
      margin: 20px auto;
      padding: 1.5rem;
      border-radius: var(--card-curve);
      box-shadow: var(--card-box-shadow);
      background: #fff;
  }
  
  .fs-30{
      font-size: 30px;
  }
  
  .w3l-login .w3l-form-36-mian {
      min-height: auto;
  }

  .mx-100{
    max-width: 100% !important;
  }

  .media_playlist{
    max-height: 90vh;
    overflow: scroll;
    overflow-x: hidden;
    
  }

  /* width */
::-webkit-scrollbar {
  width: 3px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.w3l-offered-courses .price-review p {
    font-size: 16px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.w3l-offered-courses a.course-desc {
    font-size: 16px;
    line-height: 20.2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

body{
    height:100%;
    width: 100%;
    margin:0;
    padding:0;
    font-size: 14px;
}

#floating_nav{
    position: fixed;
    /* left: 0; */
}

.comments-head{
  background-color: white;
  height: 40px;
}

#comments-list{
  width: 100%;
  min-height: 40%;
  max-height: 70vh;
  overflow-x: hidden; /* Hide horizontal scrollbar */
  overflow-y: scroll; /* Add vertical scrollbar */
}
.mediaItem_bg_image{
  width: 100%;
  height: 70vh;
  background-repeat: none;
  background-size: cover;
}
  </style>
  @yield('style')
  </head>
  <body>

    @include('web.includes.header')

    @yield('content')
    
  {{-- <!-- footer -->
  <button onclick="topFunction()" id="movetop" title="Go to top">
    <span class="fa fa-angle-up" aria-hidden="true"></span>
  </button> --}}
    @include('web.includes.footer')
    @include('web.includes.script')

  </body>

</html>
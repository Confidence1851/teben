@extends('web.layouts.app' , ['title' => 'About Us' , 'activePage' => 'about_us'])
@section('content')
<!-- breadcrum -->
<section class="w3l-skill-breadcrum">
  <div class="breadcrum">
    <div class="container">
      <p><a href="index.html">Home</a> &nbsp; / &nbsp; About</p>
    </div>
  </div>
</section>
<!-- //breadcrum -->

<div style="margin: 8px auto; display: block; text-align:center;">
  <!---728x90--->

</div>

<section class="w3l-about1" id="about">
  <div id="cwp23-block" class="py-5">
    <div class="container py-lg-5">
      <div class="row cwp23-content align-items-center">
        <div class="col-lg-6 cwp23-text">
          <div class="cwp23-title">
            <h3>Welcome to the Outstanding 
              Student Platform! </h3>
          </div>
          <div class="cwp23-text-cols">
            <div class="column">
              <span class="fa fa-smile-o" aria-hidden="true"></span>
              <a href="#">Private Lectures</a>
              <p>We make the students our utmost priority in our teachings</p>
            </div>
            <div class="column">
              <span class="fa fa-graduation-cap" aria-hidden="true"></span>
              <a href="#">Exam Registrations</a>
              <p>We help student register for internal and External Examinations</p>
            </div>
            <div class="column">
              <span class="fa fa-history" aria-hidden="true"></span>
              <a href="#">Results</a>
              <p>We have excellent records in sequence of exams</p>
            </div>
            <div class="column">
              <span class="fa fa-users" aria-hidden="true"></span>
              <a href="#">Job Opportunity</a>
              <p>We provide teaching services that creates room to work within and outside our institution</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mt-lg-0 mt-5 cwp23-img">
          <img src="{{ $web_source }}/images/homepage/image8.jpeg" class="img-fluid" alt="" />
        </div>
      </div>
    </div>
  </div>
</section>

<div style="margin: 8px auto; display: block; text-align:center;">
  <!---728x90--->
</div>

<!-- stats -->
<section class="w3l-stats py-lg-5 py-4" id="stats">
  <div class="gallery-inner container py-md-5 py-4">
    <div class="row stats-con text-white">
      <div class="col-md-3 col-6 stats_info counter_grid">
        <span class="fa fa-smile-o"></span>
        <p class="counter">196</p>
        <h4>Complete Courses</h4>
      </div>
      <div class="col-md-3 col-6 stats_info counter_grid1">
        <span class="fa fa-graduation-cap"></span>
        <p class="counter">96</p>
        <h4>Certified Teachers</h4>
      </div>
      <div class="col-md-3 col-6 stats_info counter_grid mt-md-0 mt-5">
        <span class="fa fa-history"></span>
        <p class="counter">25</p>
        <h4>Years of Experience</h4>
      </div>
      <div class="col-md-3 col-6 stats_info counter_grid2 mt-md-0 mt-5">
        <span class="fa fa-users"></span>
        <p class="counter">890</p>
        <h4>Students online</h4>
      </div>
    </div>
  </div>
</section>
<!-- //stats -->

<div style="margin: 8px auto; display: block; text-align:center;">
  <!---728x90--->
</div>

<section class="w3l-courses">
  <div class="blog py-5" id="courses">
    <div class="container py-lg-5">
      <div class="header-section text-center">
        <h3 class="mb-2">Various topics to choose from</h3>
      </div>
      
      <div class="row mt-md-5 mt-4">
        <div class="col-md-12 mx-auto">
          <div class="owl-two owl-carousel owl-theme">
            <div class="item">
              <div class="card">
                <div class="card-header p-0 position-relative">
                  <a href="#url" class="zoom d-block">
                    <img class="card-img-bottom d-block" src="{{ $web_source }}/images/g1.jpg" alt="Card image cap">
                  </a>
                  <div class="author">
                    <div class="author-image">
                      <img src="{{ $web_source }}/images/student2.jpg" class="img-fluid rounded-circle" title="Adam Ster" alt="author image">
                    </div>
                    <div class="course-title">
                      <a href="#url">click to view</a>
                    </div>
                  </div>
                </div>
                <div class="card-body course-details">
                  <div class="price-review d-flex justify-content-between mb-1align-items-center">
                    <p>Download</p>
                    <a href="#url" class="reviews d-inline-block">(56 Reviews)</a>
                  </div>
                  <a href="#url" class="course-desc">Don't be discouraged by your weaknesses 
                   Learn until you master</a>
                </div>
                <div class="card-footer course-price-view">
                  <ul class="blog-list">
                    <li>
                        <a href="#url"><span class="fa fa-heart"></span> 98</a>
                    </li>
                    <li>
                      <a href="#url"><span class="fa fa-user"></span> 15</a>
                    </li>
                </ul>
                </div>
              </div>              
            </div>

            <div class="item">
              <div class="card">
                <div class="card-header p-0 position-relative">
                  <a href="#url" class="zoom d-block">
                    <img class="card-img-bottom d-block" src="{{ $web_source }}/images/g2.jpg" alt="Card image cap">
                  </a>
                  <div class="author">
                    <div class="author-image">
                      <img src="{{ $web_source }}/images/student3.jpg" class="img-fluid rounded-circle" title="Adam Ster" alt="author image">
                    </div>
                    <div class="course-title">
                      <a href="#url">Click to view</a>
                    </div>
                  </div>
                </div>
                <div class="card-body course-details">
                  <div class="price-review d-flex justify-content-between mb-1align-items-center">
                    <p>Download</p>
                    <a href="#url" class="reviews d-inline-block">(56 Reviews)</a>
                  </div>
                  <a href="#url" class="course-desc">Don't be discouraged by your weaknesses 
                   Learn until you master</a>
                </div>
                <div class="card-footer course-price-view">
                  <ul class="blog-list">
                    <li>
                        <a href="#url"><span class="fa fa-heart"></span> 98</a>
                    </li>
                    <li>
                      <a href="#url"><span class="fa fa-user"></span> 15</a>
                    </li>
                </ul>
                </div>
              </div>              
            </div>
            
            <div class="item">
              <div class="card">
                <div class="card-header p-0 position-relative">
                  <a href="#url" class="zoom d-block">
                    <img class="card-img-bottom d-block" src="{{ $web_source }}/images/g3.jpg" alt="Card image cap">
                  </a>
                  <div class="author">
                    <div class="author-image">
                      <img src="{{ $web_source }}/images/student4.jpg" class="img-fluid rounded-circle" title="Adam Ster" alt="author image">
                    </div>
                    <div class="course-title">
                      <a href="#url">Click to View</a>
                    </div>
                  </div>
                </div>
                <div class="card-body course-details">
                  <div class="price-review d-flex justify-content-between mb-1align-items-center">
                    <p>Download</p>
                    <a href="#url" class="reviews d-inline-block">(56 Reviews)</a>
                  </div>
                  <a href="#url" class="course-desc">Don't be discouraged by your weaknesses 
                   Learn until you master</a>
                </div>
                <div class="card-footer course-price-view">
                  <ul class="blog-list">
                    <li>
                        <a href="#url"><span class="fa fa-heart"></span> 98</a>
                    </li>
                    <li>
                      <a href="#url"><span class="fa fa-user"></span> 15</a>
                    </li>
                </ul>
                </div>
              </div>              
            </div>

            <div class="item">
              <div class="card">
                <div class="card-header p-0 position-relative">
                  <a href="#url" class="zoom d-block">
                    <img class="card-img-bottom d-block" src="{{ $web_source }}/images/g5.jpg" alt="Card image cap">
                  </a>
                  <div class="author">
                    <div class="author-image">
                      <img src="{{ $web_source }}/images/student1.jpg" class="img-fluid rounded-circle" title="Adam Ster" alt="author image">
                    </div>
                    <div class="course-title">
                      <a href="#url">Click to View</a>
                    </div>
                  </div>
                </div>
                <div class="card-body course-details">
                  <div class="price-review d-flex justify-content-between mb-1align-items-center">
                    <p>Download</p>
                    <a href="#url" class="reviews d-inline-block">(56 Reviews)</a>
                  </div>
                  <a href="#url" class="course-desc">Don't be discouraged by your weaknesses 
                   Learn until you master</a>
                </div>
                <div class="card-footer course-price-view">
                  <ul class="blog-list">
                    <li>
                        <a href="#url"><span class="fa fa-heart"></span> 98</a>
                    </li>
                    <li>
                      <a href="#url"><span class="fa fa-user"></span> 15</a>
                    </li>
                </ul>
                </div>
              </div>              
            </div>
               
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
 <!--  Intro section -->
  <section class="w3l-intro" id="intro">
    <div class="new-block top-bottom">
      <div class="container">
        <div class="middle-section text-center">
          <div class="section-width mb-5">
            <h2 class="mb-5">We are true to ourselves, and commit to always perform at our best.</h2>
            <a href="contact.html" class="btn btn-light theme-button py-2 px-5">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--  //Intro section -->
<!-- team -->
<section class="w3l-team" id="team">
  <div class="team-block py-5">
    <div class="container py-lg-5">
      <div class="wthree-title">
        <div class="header-section text-center">
          <h3 class="mb-2">Meet Our Teachers</h3>
          <p>Our teachers are well refined, experienced and eloquent;
            They teach with dexterity, and produce best outcome.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-sm-6 mt-5">
          <div class="box16">
            <a href="#url"><img src="{{ $web_source }}/images/student1.jpg" alt="" class="img-fluid" /></a>
            <div class="box-content">
              <h3 class="title"><a href="#url">Victoria</a></h3>
              <span class="post">Director</span>
              <ul class="social">
                <li>
                  <a href="#" class="facebook">
                    <span class="fa fa-facebook-f"></span>
                  </a>
                </li>
                <li>
                  <a href="#" class="twitter">
                    <span class="fa fa-twitter"></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 mt-5">
          <div class="box16">
            <a href="#url"><img src="{{ $web_source }}/images/student2.jpg" alt="" class="img-fluid" /></a>
            <div class="box-content">
              <h3 class="title"><a href="#url">Michael</a></h3>
              <span class="post">Managing Director</span>
              <ul class="social">
                <li>
                  <a href="#" class="facebook">
                    <span class="fa fa-facebook-f"></span>
                  </a>
                </li>
                <li>
                  <a href="#" class="twitter">
                    <span class="fa fa-twitter"></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 mt-5">
          <div class="box16">
            <a href="#url"><img src="{{ $web_source }}/images/student3.jpg" alt="" class="img-fluid" /></a>
            <div class="box-content">
              <h3 class="title"><a href="#url">George</a></h3>
              <span class="post">Designer</a></span>
              <ul class="social">
                <li>
                  <a href="#" class="facebook">
                    <span class="fa fa-facebook-f"></span>
                  </a>
                </li>
                <li>
                  <a href="#" class="twitter">
                    <span class="fa fa-twitter"></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 mt-5">
          <div class="box16">
            <a href="#url"><img src="{{ $web_source }}/images/student4.jpg" alt="" class="img-fluid" /></a>
            <div class="box-content">
              <h3 class="title"><a href="#url">George</a></h3>
              <span class="post">Designer</a></span>
              <ul class="social">
                <li>
                  <a href="#" class="facebook">
                    <span class="fa fa-facebook-f"></span>
                  </a>
                </li>
                <li>
                  <a href="#" class="twitter">
                    <span class="fa fa-twitter"></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 mt-5">
          <div class="box16">
            <a href="#url"><img src="{{ $web_source }}/images/student1.jpg" alt="" class="img-fluid" /></a>
            <div class="box-content">
              <h3 class="title"><a href="#url">Victoria</a></h3>
              <span class="post">Director</span>
              <ul class="social">
                <li>
                  <a href="#" class="facebook">
                    <span class="fa fa-facebook-f"></span>
                  </a>
                </li>
                <li>
                  <a href="#" class="twitter">
                    <span class="fa fa-twitter"></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-6 mt-5">
          <div class="box16">
            <a href="#url"><img src="{{ $web_source }}/images/student2.jpg" alt="" class="img-fluid" /></a>
            <div class="box-content">
              <h3 class="title"><a href="#url">Michael</a></h3>
              <span class="post">Managing Director</span>
              <ul class="social">
                <li>
                  <a href="#" class="facebook">
                    <span class="fa fa-facebook-f"></span>
                  </a>
                </li>
                <li>
                  <a href="#" class="twitter">
                    <span class="fa fa-twitter"></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- //team -->
 <section class="w3l-quote py-5">
    <div class="container py-lg-3">
      <h3>Want a Tutor?</h3>
      <p>You are in the right place!</p>
      <a href="contact.html" class="btn btn-secondary theme-button">Become a Teacher</a>
      <a href="signup.html" class="btn btn-outline-secondary theme-button ml-2">Sign Up</a>
    </div>
  </section>
  @stop

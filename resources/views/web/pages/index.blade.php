@extends('web.layouts.app' , ['title' => 'Home' , 'activePage' => 'home_page'])
@section('content')
 <!--  Main banner section -->
 <section class="w3l-main-banner">
   <div class="companies20-content">
     <div class="companies-wrapper">
       <div class="container">
         <div class="banner-item">
           <div class="banner-view">
             <div class="banner-info">
               <h3 class="banner-text">
                 Learn Anytime, Anywhere.<br> Accelerate Your Future.
               </h3>
               <p class="my-4 mb-sm-5">We believe everyone has the capacity to be creative. This is where you can promote your own potential.
               </p><br>
               <a href="signup.html" class="btn btn-primary theme-button mr-3">Become a Tutor</a>
               <a href="videos.html" class="btn btn-outline-primary theme-button">videos</a>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!--  //Main banner section -->

<div style="margin: 8px auto; display: block; text-align:center;">
  <!---728x90--->

</div>

<section class="w3l-index5" id="about">
  <div class="new-block py-5">
    <div class="container py-lg-3">
      <div class="header-section text-center">
        <h3>How we Teach?</h3>
        <p class="mt-3 mb-5">We amplify important ideas in education to help students grow in their studies and talents.
          Teachers are given the opportunity to develop in their profession through our resources?</p>
        <a href="signup.html" class="btn btn-primary theme-button">Download Lessons</a>
      </div>
      <div class="list-single-view mt-5">
        <div class="row">
          <div class="col-md-12 mt-3">
            <div class="grids5-info">
              <a href="#url" class="d-block zoom"><img src="{{ $web_source }}/images/homepage/download_subjects.jpeg" alt="" class="img-fluid news-image" /></a>
              <div class="blog-info">
                <p class="date">Students Help</p>
                <h4>Download any Topic</h4>
                <p class="blog-text"> We have hundreds of topics from each of the relevant subjects available for free download
                  We have all first term topics covered.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="list-single-view mt-3">
        <div class="row">
          <div class="col-md-12 mt-3">
            <div class="grids5-info">
              <a href="#url" class="d-block zoom"><img src="{{ $web_source }}/images/p2.jpg" alt="" class="img-fluid news-image" /></a>
              <div class="blog-info">
                <p class="date">Student's Self Development</p>
                <h4>Learning</h4>
                <p class="blog-text"> For Assignment, Practices and Examinations preparations; we have made it easier for students 
                  to find solutions to difficult tasks challenge. Our video tutorials can serve you better.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="list-single-view mt-3">
        <div class="row">
          <div class="col-md-12 mt-3">
            <div class="grids5-info">
              <a href="#url" class="d-block zoom"><img src="{{ $web_source }}/images/homepage/image3.jpeg" alt="" class="img-fluid news-image" /></a>
              <div class="blog-info">
                <p class="date">For Examinations</p>
                <h4>Get the Best Tutor</h4>
                <p class="blog-text">You may want Direct Teaching for your examination or private lesson. We have competent hands. 
                  Register as a parent and make your Request</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="list-single-view mt-3">
        <div class="row">
          <div class="col-md-12 mt-3">
            <div class="grids5-info">
              <a href="#url" class="d-block zoom"><img src="{{ $web_source }}/images/homepage/image4.jpeg" alt="" class="img-fluid news-image" /></a>
              <div class="blog-info">
                <p class="date">Admission</p>
                <h4>All Schools</h4>
                <p class="blog-text">We can help you secure admission into the institution of your choice. 
                  Your success is certain</p>
              </div>
            </div>
          </div>
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
        <h4>Request a Tutor</h4>
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
        <h4>Students Enrolled</h4>
      </div>
    </div>
  </div>
</section>
<!-- //stats -->

<div style="margin: 8px auto; display: block; text-align:center;">
  <!---728x90--->
</div>

<section class="w3l-index-block4">
  <div class="feature-16-main py-5">
    <div class="container py-lg-3">
      <div class="header-section text-center">
        <h3>Our Programs</h3>
        <p class="mt-3 mb-5">We handle lectures and registrations of examinations 
For both local and international universities and colleges?</p>
      </div>
      <div class="features-grids">
        <div class="row">
          <div class="col-md-6">
            <div class="feature-16-gd">
              <div class="icon">
                <img src="{{ $web_source }}/images/seminors.png" class="img-fluid" alt="" />
              </div>
              <div class="feature-16-gd-info">
                <h4 class="mt-4 mb-2">Register with Us</h4>
                <p>Local Examinations.</p>
                <ul>
                  <li>NECO, GCE.</li>
                  <li>NABTEB.</li>
                  <li>JAMB UTME and NDA</li>
                  <li>JUPEB</li>
                </ul>
                <a href="services.html" class="btn btn-primary theme-button mt-4">Learn more</a>
              </div>
            </div>
          </div>
          <div class="col-md-6 mt-md-0 mt-4">
            <div class="feature-16-gd">
              <div class="icon">
                <img src="{{ $web_source }}/images/course.png" class="img-fluid" alt="" />
              </div>
              <div class="feature-16-gd-info">
                <h4 class="mt-4 mb-2">International Examinations</h4>
                <p>Registrations and Lectures</p>
                <ul>
                  <li>WAEC,GCE.</li>
                  <li>SAT, IGCSE.</li>
                  <li>Cambridge A'Level</li>
                  <li>TOEFL, GMAT, IELTS</li>
                </ul>
                <a href="services.html" class="btn btn-primary theme-button mt-4">Consult Us</a>
              </div>
            </div>
          </div>
          <div class="col-md-6 mt-4">
            <div class="feature-16-gd">
              <div class="icon">
                <img src="{{ $web_source }}/images/library.png" class="img-fluid" alt="" />
              </div>
              <div class="feature-16-gd-info">
                <h4 class="mt-4 mb-2">Academic Counseling</h4>
                <p>We provide a materialistic moral and academic counseling support.</p>
                <ul>
                  <li>choosing a life career becomes easier.</li>
                  <li>Safeguard outstanding performances.</li>
                  <li>Doing the right thing,
                    at the right time.</li>
                  <li>Encourage self responsibility</li>
                </ul>
                <a href="services.html" class="btn btn-primary theme-button mt-4">Request Counseling</a>
              </div>
            </div>
          </div>
          <div class="col-md-6 mt-4">
            <div class="feature-16-gd">
              <div class="icon">
                <img src="{{ $web_source }}/images/teacher.png" class="img-fluid" alt="" />
              </div>
              <div class="feature-16-gd-info">
                <h4 class="mt-4 mb-2">Expert Teachers</h4>
                <p>Our teachers are experienced and intelligent.</p>
                <ul>
                  <li>To make learning convenient and easy.</li>
                  <li>Enlightment.</li>
                  <li>Newly updated information.</li>
                  <li>Success Guaranteed</li>
                </ul>
                <a href="services.html" class="btn btn-primary theme-button mt-4">Learn more</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> 
<!-- //subscribe -->
<section class="w3l-get-started">
  <div class="new-block top-bottom">
    <div class="container">
      <div class="middle-section">
        <div class="section-width">
          <h2>Start making money from here.Invite people to watch and download your videos and you get paid</h2>
        </div>
        <div class="link-list-menu">
            <p class="mb-5">We have you in mind. Make money while you watch or download, Make Money when you teach, Make money when you upload your personal videos. We are lucrative for you!</p>
            <a href="about.html" class="btn btn-outline-light btn-more">About Us</a>
        </div>
      </div>
    </div>
  </div>
  </section>
<section class="w3l-testimonials" id="testimonials">
  <div class="testimonials py-5">
    <div class="container py-lg-5">
      <div class="header-section text-center">
        <h3>What our Student Saying</h3>
      </div>
      <div class="row mt-4">
        <div class="col-md-10 mx-auto">
          <div class="owl-one owl-carousel owl-theme">
            <div class="item">
              <div class="slider-info mt-lg-4 mt-3">
                <div class="img-circle">
                  <img src="{{ $web_source }}/images/homepage/image10.jpeg" class="img-fluid testimonial-img" alt="client image">
                </div>
                <div class="message">
                  <span class="fa fa-quote-left" aria-hidden="true"></span>
                  <p>Teben Tutors Helped me to secure admission into LASU without delay.</p>
                  <div class="name mt-4">
                    <h4>Oyindamola</h4>
                    <p>Student in LASU</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="slider-info mt-lg-4 mt-3">
                <div class="img-circle">
                  <img src="{{ $web_source }}/images/homepage/image12.jpeg" class="img-fluid testimonial-img" alt="client image">
                </div>
                <div class="message">
                  <span class="fa fa-quote-left" aria-hidden="true"></span>
                  <p>I scored 304 in my JAMB UTME 2020. I can't thank you less Teben Tutors
the teachers are wonderful</p>
                  <div class="name mt-4">
                    <h4>Ikhide Abraham</h4>
                    <p>JABITE 2020</p>
                  </div>
                </div>
            </div>
            </div>
            <div class="item">
              <div class="slider-info mt-lg-4 mt-3">
                <div class="img-circle">
                  <img src="{{ $web_source }}/images/homepage/image11.jpeg" class="img-fluid testimonial-img" alt="client image">
                </div>
                <div class="message">
                  <span class="fa fa-quote-left" aria-hidden="true"></span>
                  <p>Teben Tutors tought me well. I scored 302 in my JAMB 2020.</p>
                  <div class="name mt-4">
                    <h4>Uwagbale George</h4>
                    <p>JAMBITE 2020</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="slider-info mt-lg-4 mt-3">
                <div class="img-circle">
                  <img src="{{ $web_source }}/images/homepage/image9.jpeg" class="img-fluid testimonial-img" alt="client image">
                </div>
                <div class="message">
                  <span class="fa fa-quote-left" aria-hidden="true"></span>
                  <p>I never knew I could gain admission with my low scores in JAMB. Thanks to Teben Tutors.
The tutorial really helped me</p>
                  <div class="name mt-4">
                    <h4>Magnus</h4>
                    <p>JABITE 2020</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="w3l-faq-block py-5">
  <div class="container py-lg-5">
    <div class="header-section mb-4">
      <h3>FAQ</h3>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab"
            aria-controls="home">Teaching</a>
          <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab"
            aria-controls="profile">Courses</a>
          <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab"
            aria-controls="messages">Programs</a>
        </div>
      </div>
      <div class="col-md-8 mt-md-0 mt-5">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
            <section class="w3l-faq" id="faq">
              <div class="faq-page">
                <ul>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Biology?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis facere voluptatibus consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on English Language?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Literatures in English</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Physics</h2>
                    <p>Sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Chemistry</h2>
                    <p>Consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Mathematics</h2>
                    <p>Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis facere voluptatibus consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Economics</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Science Courses</h2>
                    <p>Sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                </ul>
              </div>
            </section>
          </div>
          <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
            <section class="w3l-faq" id="faq">
              <div class="faq-page">
                <ul>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Social Science Courses</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Tips on Art Courses</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>General Academic Tips</h2>
                    <p>Sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Causes of Failure in Examinations</h2>
                    <p>Consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Which Science Subjects are Essential for my Admision?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis facere voluptatibus consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Which Art Subjects are Essential for my Admission?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Which Social Science Subjects are Essential for my Admission?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Which Course do I Study in University?</h2>
                    <p>Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis facere voluptatibus consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda, incidunt officiis eaque iste minima autem.</p>
                  </li>
                </ul>
              </div>
            </section>
          </div>
          <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
            <section class="w3l-faq" id="faq">
              <div class="faq-page">
                <ul>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Which School can I go?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis facere voluptatibus consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>What Should I do After my Examinations?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Can I Study Abroad?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>How do I Check my Waec Results?</h2>
                    <p>Sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>How do I Change my Course/Institution?</h2>
                    <p>Consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda excepturi aperiam animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>Which Result can I use for Admission NECO/WAEC?</h2>
                    <p>Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis facere voluptatibus consectetur quae quasi fuga, ad corrupti libero omnis sapiente
                      non assumenda, incidunt officiis eaque iste minima autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>How Much is JUPEB?</h2>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis autem.</p>
                  </li>
                  <li>
                    <input type="checkbox" checked>
                    <i></i>
                    <h2>How Much is WAEC/NECO/GCE?</h2>
                    <p>Sit amet consectetur adipisicing elit. Voluptates amet earum velit nobis aliquam
                      laboriosam nihil debitis animi vitae eos nisi laudantium. Tempore reiciendis ipsam culpa, qui
                      voluptates eveniet, incidunt officiis eaque iste minima autem.</p>
                  </li>
                </ul>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<section class="w3l-subscribe">
  <div class="subscription-infhny">
    <div class="container-fluid">
      <div class="subscription-grids row">
        <div class="subscription-right form-right-inf col-lg-6 p-md-5 p-4">
          <div class="px-lg-5 py-md-0 py-3">
            <div class="header-section">
              <h3>Join us for FREE to get instant <span>email updates!</span></h3>
              <p class="mt-3">Subscribe and get notified at first on the latest update and offers!</p>
            </div>
            <form action="#" method="post" class="signin-form mt-lg-5 mt-4">
              <div class="forms-gds">
                <div class="form-input">
                  <input type="email" name="" placeholder="Your email here" required="">
                </div>
                <div class="form-input"><button class="btn btn-primary theme-button">Subscribe</button></div>
              </div>
            </form>
          </div>
        </div>
        <div class="subscription-left forms-25-info col-lg-6 ">

        </div>
      </div>
    </div>
</section>

@stop

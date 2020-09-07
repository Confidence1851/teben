@extends('layout')

@section('title')
	Contact Us
@endsection

@section('content')
    <section class="hero-wrap hero-wrap-2" style="background-image: url({{ my_asset('web/images/bg_2.jpg') }});">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Contact Us</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('index') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>
		<section class="ftco-section ftco-no-pt ftco-no-pb contact-section">
			<div class="container">
				<div class="row d-flex align-items-stretch no-gutters">
					<div class="col-md-6 p-4 p-md-5 order-md-last bg-light">
						<form action="#">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                            </div>
                        </form>
					</div>
					<div class="col-md-6 d-flex align-items-stretch">
						<div class="row d-flex contact-info">
                            <div class="col-md-12 mb-1 d-flex">
                                <div class="bg-light align-self-stretch box p-4 text-center">
                                    <h3 class="mb-2 pt-4">Address</h3>
                                  <p>B13, Prestige plaza, Jehovah witnesses junction, Bogije lagos.</p>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex">
                                <div class="bg-light mb-1 align-self-stretch box p-4 text-center">
                                    <h3 class="mb-2">Contact Number</h3>
                                  <p><a href="tel://+2347033964406">+2347033964406</a></p>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex">
                                <div class="bg-light mb-1 align-self-stretch box p-4 text-center">
                                    <h3 class="mb-2">Email Address</h3>
                                  <p><a href="mailto:info@yoursite.com">info@tebentutors.com</a></p>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex">
                                <div class="bg-light mb-1 align-self-stretch box p-4 text-center">
                                    <h3 class="mb-2">Social Media</h3>
                                  <p><a href=" https://www.facebook.com/tebebentutors">Facebook</a></p>
                                </div>
                            </div>
                          </div>
					</div>
				</div>
			</div>
    </section>

@endsection

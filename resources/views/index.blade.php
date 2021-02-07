@extends('layout')

@section('title')
	Home
@endsection

@section('content')
    <section class="ftco-intro" style="background-image: url({{ $web_source }}/images/homepage/image1.jpeg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<h2>Groom your child for a brighter tomorrow</h2>
						<p class="mb-0"> Qualified teachers , ever ready to make learning fun for your kids.</p>
					</div>
					<div class="col-md-3 d-flex align-items-center">
						<p class="mb-0"><a href="{{ route('teachers') }}" class="btn btn-secondary px-4 py-3">See Teachers</a></p>
					</div>
				</div>
			</div>
		</section>

    <section class="ftco-services ftco-no-pb">
			<div class="container-wrap">
				<div class="row no-gutters">
          <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 ftco-animate bg-primary">
            <div class="media block-6 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center">
            		<span class="flaticon-teacher"></span>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Certified Teachers</h3>
                <p>Tested and trusted friendly teachers ever ready to make learning fun filled.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 ftco-animate bg-tertiary">
            <div class="media block-6 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center">
            		<span class="flaticon-reading"></span>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Thorough Education</h3>
                <p>Learning with the right teacher is FUN. Let your kids experience detailed education.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 ftco-animate bg-fifth">
            <div class="media block-6 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center">
            		<span class="flaticon-books"></span>
              </div>
              <div class="media-body p-2 mt-3">
                <h3 class="heading">Book &amp; Library</h3>
                <p>Kids love beautiful pictures, and thats why we employ visual tools to ensure maximum learning experience.</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 d-flex services align-self-stretch pb-4 px-4 ftco-animate bg-quarternary">
            <div class="media block-6 d-block text-center">
              <div class="icon d-flex justify-content-center align-items-center">
            		<span class="flaticon-diploma"></span>
              </div>
              <div class="media-body p-2 mt-3"  id="readmore">
                <h3 class="heading">Tests</h3>
                <p>Every lesson session is accompanied by a lesson test.This would keep your child busy.</p>
              </div>
            </div>
          </div>
        </div>
			</div>
		</section>

		<section class="ftco-section ftco-no-pt ftc-no-pb" >
			<div class="container" >
				<div class="row">
					<div class="col-md-5 order-md-last wrap-about py-5 wrap-about bg-light">
						<div class="text px-4 ftco-animate">
	          	<h2 class="mb-4">Welcome to Teben Tutors</h2>
	          	        <p>Kids are wonderful and intelligent beings. Out of love, we are determined to reduce the stress parents and guardians go through just to get a qualified tutor for their kids. The search ends here!</p>
						</div>
					</div>
					<div class="col-md-7 wrap-about py-5 pr-md-4 ftco-animate">
          	<h2 class="mb-4">What We Offer</h2>
						<div class="row mt-5">
							<div class="col-lg-6">
								<div class="services-2 d-flex">
									<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span class="flaticon-security"></span></div>
									<div class="text">
										<h3>Safety First</h3>
										<p>All teachers have been carefully screened, we guarantee your safety.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="services-2 d-flex">
									<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span class="flaticon-reading"></span></div>
									<div class="text">
										<h3>Regular Classes</h3>
										<p>Puntuality cannot be overemphasized. We keep our words.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="services-2 d-flex">
									<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span class="flaticon-diploma"></span></div>
									<div class="text">
										<h3>Qualified Teachers</h3>
										<p>You want qualified teachers?  WE GOT THEM!</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="services-2 d-flex">
									<div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span class="flaticon-education"></span></div>
									<div class="text">
										<h3>Flexible Lessons</h3>
										<p>You are in control. Simply tell us when you want us to come around.</p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-intro" style="background-image: url({{ $web_source }}/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<h2>Groom your child for a brighter tomorrow</h2>
					</div>
					<div class="col-md-3 d-flex align-items-center">
						<p class="mb-0"><a href="{{ route('teachers') }}" class="btn btn-secondary px-4 py-3">Take a Course</a></p>
					</div>
				</div>
			</div>
		</section>




    <section class="ftco-section ftco-consult ftco-no-pt ftco-no-pb" style="background-image: url({{ $web_source }}/images/bg_5.jpg);" data-stellar-background-ratio="0.5">
    	<div class="container">
    		<div class="row justify-content-end">
    			<div class="col-md-6 py-5 px-md-5 bg-primary">
	          <div class="heading-section heading-section-white ftco-animate mb-5">
	            <h2 class="mb-4">Get in touch</h2>
	            <p>We are always ready to attend to your needs.</p>
	          </div>
	          <form action="#" class="appointment-form ftco-animate">
	    				<div class="d-md-flex">
		    				<div class="form-group">
		    					<input type="text" class="form-control" placeholder="Full Name">
		    				</div>

	    				</div>
	    				<div class="d-md-flex">
	    					<div class="form-group ml-md-4">
		    					<input type="text" class="form-control" placeholder="Email address">
		    				</div>

	    					<div class="form-group ml-md-4">
		    					<input type="text" class="form-control" placeholder="Phone">
		    				</div>
	    				</div>
	    				<div class="d-md-flex">
	    					<div class="form-group">
		              <textarea name="" id="" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
		            </div>
		            <div class="form-group ml-md-4">
		              <input type="submit" value="Send Message" class="btn btn-secondary py-3 px-4">
		            </div>
	    				</div>
	    			</form>
    			</div>
        </div>
    	</div>
    </section>


@endsection

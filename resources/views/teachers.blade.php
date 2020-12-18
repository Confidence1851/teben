@extends('layout')

@section('title')
	Teachers
@endsection

@section('content')
    <section class="hero-wrap hero-wrap-2" style="background-image: url({{ my_asset('web/images/bg_2.jpg') }});">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-2 bread">Certified Teachers</h1>
            <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('index') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Teachers <i class="ion-ios-arrow-forward"></i></span></p>
          </div>
        </div>
      </div>
    </section>

		<section class="ftco-section ftco-no-pb">
			<div class="container">
				<div class="row">
				     @foreach($teachers as $teacher)
				     @php($major = App\Models\Subject::where('id',$teacher->major)->first())
					<div class="col-md-6 col-lg-3 ftco-animate">
						<div class="staff">
							<div class="img-wrap d-flex align-items-stretch">
								<div class="img align-self-stretch" style="background-image: url({{ $teacher->user->getAvatar() }});"></div>
							</div>
							<div class="text pt-3 text-center">
								<h3> <a href="{{route('teacherinfo',$teacher->user->uuid)}}">{{ $teacher->user->name }}</a></h3>
								<span class="position mb-2">{{ $major->name }}</span>
								<div class="faded">
									<p style="margin:0;padding:0">{{ $teacher->yrs_experience }}+ years of experience</p>
									<p style="margin:0;padding:0">Lessons Completed : 0</p>
	              				</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</section>

@endsection

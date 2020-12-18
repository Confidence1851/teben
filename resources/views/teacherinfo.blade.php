@extends('layout')

@section('title')
	Teacher Information
@endsection

@section('content')


		<section class="">
			<div class="container">
			    <h3 class="text-center mt-3"><b>Verified Teben Tutor</b> </h3>
				<div class="row mt-3">
					<div class="offset-md-2 col-md-4">
						<img src="{{ $teacher->getAvatar() }}" class="img img-fluid"/>
					</div>

					<div class="col-md-4">
					    <div class="text pt-3 text-center">
					        @php($major = App\Models\Subject::where('id',$teacher->teacher->major)->first())
								<h3>{{ $teacher->name }}</h3>
								<p class=" mb-2">Gender: {{ $teacher->gender }}</p>
								<p class=" mb-2">Major Subject: {{ $major->name }}</p>
								<p class=" mb-2">Qualification: {{ $teacher->teacher->qualification }}</p>
								<p class=" mb-2">Specialty: {{ $teacher->teacher->specialty }}</p>
								<div class="">
									<p style="margin:0;padding:0">{{ $teacher->teacher->yrs_experience }}+ years of experience</p>
									<p style="margin:0;padding:0">Lessons Completed : {{ $teacher->teacher->jobs }}</p>
	              				</div>
	              				<p class="mt-3">
	              				    <img src="{{ $teacher->getUUID() }}" alt="" style="width: 30%"/>
	              				</p>
							</div>
					</div>
				</div>
			</div>
		</section>

@endsection

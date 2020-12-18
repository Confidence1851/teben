<!-- header -->
<header class="w3l-header" >
	<div class="hero-header-11" >
		<div class="hero-header-11-content" >
			<div class="container" >
				<nav class="navbar navbar-expand-lg navbar-light py-md-2 py-0 px-0 sticky-top" >
					<a class="navbar-brand" href="{{ route('index') }}"><img src="{{ $logo_img }}" width="50" height="50" alt="" class="d-none" />Teben Tutors</a>
					<!-- if logo is image enable this   
				<a class="navbar-brand" href="#{{ route('index') }}">
						<img src="image-path" alt="Your logo" title="Your logo" style="height:35px;" />
				</a> -->
					<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
						aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
						<span class="navbar-toggler-icon fa icon-close fa-times"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item {{ $activePage == "home_page" ? 'active' : ''  }}">
								<a class="nav-link" href="{{ route('index') }}">Home <span class="sr-only">(current)</span></a>
							</li>
							<li class="nav-item {{ $activePage == "about_us" ? 'active' : ''  }}">
								<a class="nav-link" href="{{ route('about_us') }}">About</a>
							</li>
							<li class="nav-item  {{ $activePage == "services" ? 'active' : ''  }}">
								<a class="nav-link" href="{{  route('services') }}">Services</a>
							</li>
							<li class="nav-item {{ $activePage == "media" ? 'active' : ''  }}">
								<a class="nav-link" href="{{ route("media_collection.index" , ["type" => "videos"]) }}">Media</a>
							</li>
							
							<li class="nav-item {{ $activePage == "contact_us" ? 'active' : ''  }}">
								<a class="nav-link" href="{{ route('contact_us') }}">Contact Us</a>
							</li>
							
							@if(!auth()->check())
								<li class="nav-item {{ $activePage == "login" ? 'active' : ''  }}">
									<a class="nav-link" href="{{ route('login') }}">Login</a>
								</li>
							@else
								<li class="nav-item dropdown @@dropdown-active">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										{{ auth()->user()->name }}
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="{{ route("home") }}" >Dashboard</a>
										<a class="dropdown-item" href="{{ route('user.media.index' , "books") }}" >Books</a>
										<a class="dropdown-item" href="{{ route('user.media.index' , "videos") }}" >Videos</a>
										<a class="dropdown-item" href="{{ route("user.referrals") }}" >Referrals</a>
										<a class="dropdown-item" href="{{ route("home") }}" >My Profile</a>
										<a class="dropdown-item" href="#" onclick=" return $('#logout_form').trigger('submit'); ">Log out</a>
									</div>
								</li>
								<form action="{{ route("logout") }}" method="post" class="d-none" id="logout_form">@csrf</form>
							@endif
						</ul>
						@if(!auth()->check())
							<div class="form-inline ml-lg-3">
								<a href="{{ route('register') }}" class="btn btn-primary theme-button">Join Us</a>
							</div>
						@endif
					</div>
				</nav>
			</div>
		</div>
	</div>
</header>
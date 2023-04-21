<!--layout blade for every landing page, with fonts, navbar and footer-->
@extends('bootstrap')
<body class="bg-darker text-light"></body>
<style>
	.bg-darker {
	  background-image: linear-gradient(to bottom, #191919, #171717)!important;
	}
	@font-face {
	  font-family: "fournier";
	  src: url("fonts/FournierMTStdRegular.woff") format('woff');
	}
	@font-face {
	  font-family: "kentledge";
	  src: url("fonts/kentledge-heavy.otf") format('otf');
	}
	@font-face {
	  font-family: "cormorant";
	  src: url("fonts/CormorantGaramond-BoldItalic.ttf") format('truetype');
	}
	@font-face {
	  font-family: "raleway";
	  src: url("fonts/Raleway-VariableFont_wght.ttf") format('truetype');
	}
	.bg-darker {
		font-family: 'raleway', sans-serif;
	}
	.separator {
		font-family: 'cormorant', serif;
	}
	.shadowed-image {
		font-family: 'fournier', sans-serif;
	}
</style>
@section('page')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid fs-3">
        <a class="navbar-brand" href="/"><img src="{{ asset('images/logo-text.png') }}" class="logo" height="100" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto" style="margin-right: 5%;">
                <a class="nav-link mx-1" href="/reservation">{{ __('front.reservation') }}</a>
				<a class="nav-link mx-1" href="/menu">{{ __('front.menu') }}</a>
				<a class="nav-link mx-1" href="/events">{{ __('front.events') }}</a>
				<a class="nav-link mx-1" href="/contact">{{ __('front.contact') }}</a>
				<a class="nav-link mx-1" href="/login">{{ __('front.login') }}</a>
				<a class="nav-link mx-1" href="/register">{{ __('front.register') }}</a>
            </div>
        </div>
    </div>
</nav>

	
@yield('content')

<footer class="footer mt-auto py-5 bg-dark bg-gradient text-warning">
	<div class="container">
		<div class="row align-items-center justify-content-center">
			<div class="col-auto mb-3 mb-md-0">
				<a href="/" class="no-animation"><img src="{{ asset('images/logo.png') }}" alt="Logo" width="220" class="img-fluid mb-5"></a>
			</div>
			<div class="col-12 col-md-auto">
				<div class="row text-center gx-5">
					<div class="col-12 col-md min-width">
						<h4>{{ __('front.information') }}</h4>
						<hr>
						<ul class="list-unstyled larger-text">
							<li><a href="/register">{{ __('front.register') }}</a></li>
							<li><a href="/login">{{ __('front.login') }}</a></li>
							<li><a href="/reservation">{{ __('front.make_reservation') }}</a></li>
							<li><a href="/terms">{{ __('front.terms_of_service') }}</a></li>
							<li><a href="/cookie-consent">{{ __('front.cookie_consent') }}</a></li>
						</ul>
					</div>
					<div class="col-12 col-md min-width">
						<h4>{{ __('front.about_us') }}</h4>
						<hr>
						<ul class="list-unstyled larger-text">
							<li>{{ __('front.hours') }}</li>
							<li><a href="/contact#faq-section">{{ __('front.faq') }}</a></li>
							<li><a href="/newsletter">{{ __('front.newsletter') }}</a></li>
							<li><a href="/contact">{{ __('front.contact') }}</a></li>
						</ul>
					</div>
					<div class="col-12 col-md min-width">
						<h4>{{ __('front.contact') }}</h4>
						<hr>
						<ul class="list-unstyled larger-text">
							<li><i class="fas fa-phone"></i> {{ __('front.phone') }}</li>
							<li><i class="fas fa-envelope"></i> <a href="mailto:example@example.com">{{ __('front.email') }}</a></li>
							<li><a href="/contact#map"><i class="fas fa-map-marker"></i> {{ __('front.street') }}</a></li>
						</ul>
						<a href="https://www.facebook.com/" class="no-animation"><i class="fab fa-facebook fa-2x yellow-icon"></i></a>
						<a href="https://twitter.com/" class="no-animation"><i class="fab fa-twitter fa-2x yellow-icon"></i></a>
						<a href="https://www.instagram.com/" class="no-animation"><i class="fab fa-instagram fa-2x yellow-icon"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--footer styles-->
	<style>
		.min-width {
		  min-width: 350px;
		}

		.larger-text {
		  font-size: 1.2em;
		}

		.yellow-icon {
		  color: #FFD700;
		}
		.footer a {
			color: inherit;
			text-decoration: none;
			position: relative;
		}

		.footer a:not(.no-animation):hover::after {
			content: "";
			position: absolute;
			bottom: 0;
			left: 0;
			right: 0;
			height: 2px;
			background-color: currentColor;
		}
	</style>
</footer>
@stop
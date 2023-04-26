@extends('layout')
@section('content')
<style>
	.form-control {
		border: 2px solid;
		border-image-slice: 1;
		border-image-source: linear-gradient(to right, #8e642b, #f6f6a3, #8e642b);
		background-color: #343a40;
		color: white;
	}

	form {
		width: 50%;
		margin: 0 auto;
	}

	input::placeholder,
	textarea::placeholder,
	select {
		color: darkgray !important;
	}

	input:focus,
	select:focus,
	textarea:focus {
		color: white !important;
		background-color: #343a40 !important;
	}
	#hours {
		background-color: #8FBC8F;
	}
	.hours-text {
		font-size: 28px;
		color: #3b4f3b;
	}
</style>

<!--form-->
<div class="container" style="max-width: 80%;">
	<h1 class="text-center m-5">{{ __('front.contact_title') }}</h1>
	<h5 class="text-center mb-4">{{ __('front.contact_description') }}</h5>
	
	<form action="/contact" method="post">
		@csrf
		<div class="form-group mb-3">
			<input type="text" name="name" id="name" value="{{ auth()->user()->name ?? '' }}" class="form-control rounded-0" placeholder="{{ __('front.name_label') }}" required>
		</div>
		<div class="form-group mb-3">
			<input type="email" name="email" id="email" value="{{ auth()->user()->email ?? '' }}" class="form-control rounded-0" placeholder="{{ __('front.email_label') }}" required>
		</div>
		<div class="form-group mb-3">
			<input type="number" name="number" id="number" class="form-control rounded-0" placeholder="{{ __('front.number_label') }}">
		</div>
		<div class="form-group mb-3">
			<select name="reason" id="reason" class="form-control rounded-0">
				<option value="" disabled selected>{{ __('front.reason_select') }}</option>
				<option value="reservation">{{ __('front.reason_reservation') }}</option>
				<option value="event">{{ __('front.reason_event') }}</option>
				<option value="feedback">{{ __('front.reason_feedback') }}</option>
				<option value="other">{{ __('front.reason_other') }}</option>
			</select>
		</div>
		<div class="form-group mb-3">
			<textarea name="message" id="message" class="form-control rounded-0" rows="7" placeholder="{{ __('front.message_label') }}" required></textarea>
		</div>
		<div class="form-group mb-3">
			<div class="g-recaptcha" data-sitekey="6LcarrMlAAAAAC1OIuxhuSBhuymc8wOs_JNGjchd"></div>
		</div>
		<div class="form-group mb-3 d-flex justify-content-center">
			<!--id to redirect here if the message is sent-->
			<button type="submit" class="btn btn-primary rounded-0" id="sent">{{ __('front.send_button') }}</button>
		</div>
	</form>
</div>

@if (session('success'))
	<div class="alert alert-success mb-0 rounded-0 mb-4">
		{{ session('success') }}
	</div>
@endif
	
<!--find us separator-->
<div class="mt-5" id="map">
	<x-shadowed-image image="{{ asset('/images/contact/background.jpg') }}" text="{{ __('front.find_us') }}" height="200px" font-size="60px" shadow-opacity="0.1" />
</div>


<!--hours-map boxes-->
<div class="container-fluid">
    <div class="row vh-100">
        <div id="hours" class="col-md-6 px-0 d-flex flex-column justify-content-center text-white">
            <div class="text-center">
                <h3 class="display-4">{{ __('front.restaurant_title') }}</h3>
                <ul class="list-unstyled mb-5">
                    <li class="h5 hours-text">{{ __('front.restaurant_hours1') }}</li>
                    <li class="h5 hours-text">{{ __('front.restaurant_hours2') }}</li>
                </ul>

                <h3 class="display-4">{{ __('front.kitchen_title') }}</h3>
                <ul class="list-unstyled mb-5">
                    <li class="h5 hours-text">{{ __('front.kitchen_hours1') }}</li>
                    <li class="h5 hours-text">{{ __('front.kitchen_hours2') }}</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 px-0">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3029.5501887323453!2d-3.2510810845986002!3d40.59568317934475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd43ad5177346f55%3A0x91049b7c76633d4d!2sEl%20Nuevo%20Porton!5e0!3m2!1ses!2ses!4v1682038835540!5m2!1ses!2ses" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>

<!--FAQ-->
<div class="container my-5 py-5" id="faq-section">
    <h1 class="mb-4 display-3">{{ __('front.faq') }}</h1>
    <ul class="list-unstyled">
        <li class="mb-3 h5"><strong>{{ __('front.question1') }}</strong><br><i>{{ __('front.answer1') }}</i></li>
        <li class="mb-3 h5"><strong>{{ __('front.question2') }}</strong><br><i>{{ __('front.answer2') }}</i></li>
        <li class="mb-3 h5"><strong>{{ __('front.question3') }}</strong><br><i>{{ __('front.answer3') }}</i></li>
        <li class="mb-3 h5"><strong>{{ __('front.question4') }}</strong><br><i>{{ __('front.answer4') }}</i></li>
        <li class="mb-3 h5"><strong>{{ __('front.question5') }}</strong><br><i>{{ __('front.answer5') }}</i></li>
        <li class="mb-3 h5"><strong>{{ __('front.question6') }}</strong><br><i>{{ __('front.answer6') }}</i></li>
        <li class="mb-3 h5"><strong>{{ __('front.question7') }}</strong><br><i>{{ __('front.answer7') }}</i></li>
        <li class="mb-3 h5"><strong>{{ __('front.question8') }}</strong><br><i>{{ __('front.answer8') }}</i></li>
    </ul>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@stop
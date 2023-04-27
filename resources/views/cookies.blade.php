@extends('layout')
@section('content')

<!--Terms of service-->
<div id="terms" class="container">
<h1 class="my-4">{{ __('front.terms_of_service') }}</h1>
	<div class="fs-5">
	<p>{{ __('front.welcome_to_our_restaurant') }}</p>
	<ol>
		<li>{{ __('front.prices_subject_to_change') }}</li>
		<li>{{ __('front.right_to_refuse_service') }}</li>
		<li>{{ __('front.not_responsible_for_lost_items') }}</li>
		<li>{{ __('front.accommodate_dietary_restrictions') }}</li>
		<li>{{ __('front.no_outside_food') }}</li>
		<li>{{ __('front.accurate_information') }}</li>
		<li>{{ __('front.cancellations') }}</li>
		<li>{{ __('front.dispute_resolution') }}</li>
	</ol>
	<p>{{ __('front.thank_you') }}</p>
	</div>
</div>

<!--Cookies-->
<div id="cookies" class="container">
  <h1 class="my-4">{{ __('front.cookies') }}</h1>
  <p class="fs-5">{!! __('front.cookie_consent_message_long') !!}</p>

  <h2 class="my-4">{{ __('front.cookie_settings') }}</h2>
  <form>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="essentialCookiesCheck" checked disabled>
      <label class="form-check-label" for="essentialCookiesCheck">
        {{ __('front.essential_cookies') }}
      </label>
    </div>
    <div class="form-check">
	  <input class="form-check-input" type="checkbox" value="" id="analyticsCookiesCheck" {{ isset($_COOKIE['analytics_cookies']) && $_COOKIE['analytics_cookies'] === 'true' ? 'checked' : '' }}>
	  <label class="form-check-label" for="analyticsCookiesCheck">
		{{ __('front.analytics_cookies') }}
	  </label>
	</div>
	<div class="form-check">
	  <input class="form-check-input" type="checkbox" value="" id="advertisingCookiesCheck" {{ isset($_COOKIE['advertising_cookies']) && $_COOKIE['advertising_cookies'] === 'true' ? 'checked' : '' }}>
	  <label class="form-check-label" for="advertisingCookiesCheck">
		{{ __('front.advertising_cookies') }}
	  </label>
	</div>
    <button type="submit" class="btn btn-primary my-3">{{ __('front.save_settings') }}</button>
  </form>
</div>

<script>
	// Agrega un controlador de eventos al botón "Save Settings"
document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
  // Evita que se envíe el formulario
  event.preventDefault();

  // Lee el estado de las casillas de verificación
  var analyticsCookies = document.querySelector('#analyticsCookiesCheck').checked;
  var advertisingCookies = document.querySelector('#advertisingCookiesCheck').checked;

  // Establece cookies con las preferencias del usuario
  document.cookie = 'analytics_cookies=' + analyticsCookies + '; path=/';
  document.cookie = 'advertising_cookies=' + advertisingCookies + '; path=/';

  // Muestra un mensaje de confirmación al usuario
  alert("{{ __('front.cookie_feedback') }}");
});
</script>
@stop
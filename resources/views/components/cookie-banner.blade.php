<!-- Cookie Consent Bar -->
<style>
	.btn {
		height: 38px;
	}
</style>
<div class="fixed-bottom bg-light p-3 bg-dark text-white d-none" id="cookieConsentBar">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      {{ __('front.cookie_consent_message') }} <a href="/cookie-consent">{{ __('front.learn_more') }}</a>
    </div>
    <div class="d-flex ms-4">
      <button type="button" class="btn btn-secondary btn-sm me-2" id="cookieConsentDecline">{{ __('front.decline') }}</button>
      <button type="button" class="btn btn-primary btn-sm" id="cookieConsentAccept">{{ __('front.accept') }}</button>
    </div>
  </div>
</div>

<script>
	//cookie check
	window.onload = function() {
	  if (!document.cookie.split('; ').find(row => row.startsWith('analytics_cookies')) && !document.cookie.split('; ').find(row => row.startsWith('advertising_cookies'))) {
		var cookieConsentBar = document.getElementById('cookieConsentBar');
		cookieConsentBar.classList.remove('d-none');
	  }
	};
	
	//accept
	var acceptButton = document.querySelector('#cookieConsentAccept');
	acceptButton.addEventListener('click', function() {
	  document.cookie = 'analytics_cookies=true; path=/';
	  document.cookie = 'advertising_cookies=true; path=/';

	  var cookieConsentBar = document.getElementById('cookieConsentBar');
	  cookieConsentBar.classList.add('d-none');
	});
	
	//decline
	var declineButton = document.querySelector('#cookieConsentDecline');
	declineButton.addEventListener('click', function() {
	  document.cookie = 'analytics_cookies=false; path=/';
	  document.cookie = 'advertising_cookies=false; path=/';

	  var cookieConsentBar = document.getElementById('cookieConsentBar');
	  cookieConsentBar.classList.add('d-none');
	});
</script>
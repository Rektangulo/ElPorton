@php
    $currentLocale = app()->getLocale();
@endphp
<div class="dropdown">
  <a class="btn btn-secondary dropdown-toggle" style="width: 80px;" href="#" role="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <img src="{{ asset("/images/languages/$currentLocale.png") }}" alt="Flag" style="width: 40px;">
  </a>
  <ul class="dropdown-menu" aria-labelledby="languageDropdown">
    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('language.switch', 'es') }}"><img src="{{ asset('/images/languages/es.png') }}" alt="Flag" style="width: 40px; margin-right: 10px;">Español</a></li>
    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('language.switch', 'en') }}"><img src="{{ asset('/images/languages/en.png') }}" alt="Flag" style="width: 40px; margin-right: 10px;">English</a></li>
  </ul>
</div>


@extends('layout')
@section('content')
<style>

	.carousel-shadow {

	  background-image: linear-gradient(to top, rgba(0, 0, 0, 0.95), transparent);
	}
	.carousel-item {
	  max-height: 900px;
	}
</style>
<!--first image with quote-->
<x-shadowed-image image="{{ asset('/images/landing/background.jpg') }}" text="{{ __('front.landing_description') }}" />


<!--images with text in 2x2 grid-->
<div class="container-fluid my-5">
  <div class="row">
    <div class="col-md-6 text-center d-flex align-items-center">
      <img src="{{asset('images/landing/party.jpeg')}}" style="max-width: 80%;" class="img-fluid my-3 smaller-image mx-auto rounded closer-to-center" alt="Image">
    </div>
    <div class="col-md-6 text-center d-flex align-items-center">
      <div class="card bg-darker text-light w-100 less-wide border border-light rounded-0 mx-auto" style="max-width: 60%;">
        <div class="card-body">
          <h2 class="card-title">{{ __('front.host_card') }}</h2>
          <p class="card-text mt-3 lead">{{ __('front.host_card_text') }}</p>
          <a href="/reservation" class="btn btn-light">{{ __('front.host_card_button') }}</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 text-center d-flex align-items-center order-md-2">
      <img src="{{asset('images/landing/menu.jpg')}}" style="max-width: 80%;" class="img-fluid my-3 smaller-image mx-auto rounded closer-to-center" alt="Image">
    </div>
    <div class="col-md-6 text-center d-flex align-items-center order-md-1">
      <div class="card bg-darker text-light w-100 less-wide border border-light rounded-0 mx-auto" style="max-width: 60%;">
        <div class="card-body">
          <h2 class="card-title">{{ __('front.menu_card') }}</h2>
          <p class="card-text mt-3 lead">{{ __('front.menu_card_text') }}</p>
          <a href="/menu" class="btn btn-light">{{ __('front.menu_card_button') }}</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Separator -->
<div class="separator text-center fs-1 m-5">
  <p>{{ __('front.quote') }}</p>
</div>

<!--carousel-->
<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="true">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
  <div class="carousel-item active">
    <img src="{{ asset('images/landing/carousel/carousel1.jpg')}}" class="d-block w-100 img-fluid" alt="carousel1">
	<div class="carousel-shadow position-absolute bottom-0 start-0 end-0 h-50"></div>
    <div class="carousel-caption d-none d-md-block fs-4">
      <h5>{{ __('front.carousel1_title') }}</h5>
      <p>{{ __('front.carousel1_text') }}</p>
    </div>
  </div>
  <div class="carousel-item">
    <img src="{{ asset('images/landing/carousel/carousel2.jpg')}}" class="d-block w-100 img-fluid" alt="carousel2">
	<div class="carousel-shadow position-absolute bottom-0 start-0 end-0 h-50"></div>
    <div class="carousel-caption d-none d-md-block fs-4">
      <h5>{{ __('front.carousel2_title') }}</h5>
      <p>{{ __('front.carousel2_text') }}</p>
    </div>
  </div>
  <div class="carousel-item">
    <img src="{{ asset('images/landing/carousel/carousel3.jpg')}}" class="d-block w-100 img-fluid" alt="carousel3">
	<div class="carousel-shadow position-absolute bottom-0 start-0 end-0 h-50"></div>
    <div class="carousel-caption d-none d-md-block fs-4">
      <h5>{{ __('front.carousel3_title') }}</h5>
      <p>{{ __('front.carousel3_text') }}</p>
    </div>
  </div>
</div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">{{ __('front.previous') }}</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">{{ __('front.next') }}</span>
  </button>
</div>

@stop
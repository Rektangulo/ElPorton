@extends('layout')
<body class="bg-darker text-light"></body>
@section('content')
<style>
@font-face {
  font-family: "fournier";
  src: url("fonts/FournierMTStdRegular.woff") format('woff');
}
@font-face {
  font-family: "kentledge";
  src: url("fonts/kentledge-heavy.otf") format('otf');
}
.text-white p {
    font-family: 'fournier', sans-serif;
}
	
.bg-darker {
  background-image: linear-gradient(to bottom, #191919, #171717)!important;
}

.carousel-item {
  max-height: 900px;
}

.separator {
	font-family: 'kentledge', serif;
}

.carousel-shadow {
	
  background-image: linear-gradient(to top, rgba(0, 0, 0, 0.95), transparent);
}

</style>
<!--first image with quote-->
<div class="position-relative">
    <img src="http://homestead.test/images/landing/background.jpg" alt="" class="img-fluid w-100" style="height: 700px; object-fit: cover;">
    <div class="position-absolute w-100 h-100" style="top: 0; background-color: rgba(0, 0, 0, 0.5);"></div>
    <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center text-white" style="top: 0;">
        <p class="text-center mx-auto" style="max-width: 60%; font-size: 34px;">Visit our cozy restaurant nestled in the heart of town next to the historic church. Indulge in our unique fusion of Spanish and Chinese cuisine, expertly crafted from the freshest ingredients. Relax with a drink at our bar and enjoy the warm and welcoming atmosphere. We look forward to serving you.</p>
    </div>
</div>

<!--images with text in 2x2 grid-->
<div class="container-fluid my-5">
  <div class="row">
    <div class="col-md-6 text-center d-flex align-items-center">
      <img src="{{asset('images/landing/party.jpeg')}}" style="max-width: 80%;" class="img-fluid my-3 smaller-image mx-auto rounded closer-to-center" alt="Image">
    </div>
    <div class="col-md-6 text-center d-flex align-items-center">
      <div class="card bg-darker text-light w-100 less-wide border border-light mx-auto" style="max-width: 60%;">
        <div class="card-body">
          <h2 class="card-title">Host A Party</h2>
          <p class="card-text mt-3 lead">We recommend celebrating all moments, big or small. Here, you don't need an excuse to gather.</p>
          <button type="button" class="btn btn-light">Learn More</button>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 text-center d-flex align-items-center order-md-2">
      <img src="{{asset('images/landing/menu.jpg')}}" style="max-width: 80%;" class="img-fluid my-3 smaller-image mx-auto rounded closer-to-center" alt="Image">
    </div>
    <div class="col-md-6 text-center d-flex align-items-center order-md-1">
      <div class="card bg-darker text-light w-100 less-wide border border-light mx-auto" style="max-width: 60%;">
        <div class="card-body">
          <h2 class="card-title">Menus</h2>
          <p class="card-text mt-3 lead">Come see the items featured from our scratch made kitchen.</p>
          <button type="button" class="btn btn-light">View Menu</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Separator -->
<div class="separator text-center fs-1 m-5">
  <p>"GOOD FOOD IS THE FOUNDATION OF GENUINE HAPPINESS"</p>
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
      <h5>A feast for the senses</h5>
      <p>Our dishes are expertly crafted to delight your taste buds, while our charming ambiance will transport you to another world. Come dine with us and experience the magic for yourself.</p>
    </div>
  </div>
  <div class="carousel-item">
    <img src="{{ asset('images/landing/carousel/carousel2.jpg')}}" class="d-block w-100 img-fluid" alt="carousel2">
	<div class="carousel-shadow position-absolute bottom-0 start-0 end-0 h-50"></div>
    <div class="carousel-caption d-none d-md-block fs-4">
      <h5>Good food, good company</h5>
      <p>There’s nothing quite like sharing a meal with good company. At our restaurant we offer a warm and welcoming atmosphere where you can enjoy delicious food and great conversation. Join us for a meal that will leave you feeling satisfied and happy.</p>
    </div>
  </div>
  <div class="carousel-item">
    <img src="{{ asset('images/landing/carousel/carousel3.jpg')}}" class="d-block w-100 img-fluid" alt="carousel3">
	<div class="carousel-shadow position-absolute bottom-0 start-0 end-0 h-50"></div>
    <div class="carousel-caption d-none d-md-block fs-4">
      <h5>Indulge in culinary delights</h5>
      <p>Treat yourself to a meal that will tantalize your taste buds. Our restaurant offers a diverse selection of dishes that are expertly prepared to delight your senses. From bold flavors to subtle nuances, our menu has something for everyone. Join us for a dining experience that will leave you feeling satisfied and fulfilled.</p>
    </div>
  </div>
</div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

@stop
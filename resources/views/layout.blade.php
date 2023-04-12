@extends('bootstrap')
@section('page')
<footer class="footer mt-auto py-5 bg-dark bg-gradient text-warning">
<div class="container">
  <div class="row align-items-center justify-content-center">
    <div class="col-auto mb-3 mb-md-0">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid logo mb-5">
    </div>
    <div class="col-12 col-md-auto">
      <div class="row text-center gx-5">
        <div class="col-12 col-md min-width">
          <h4>Information</h4>
          <hr>
          <ul class="list-unstyled larger-text">
            <li>Register</li>
            <li>Login</li>
            <li>Make reservation</li>
			<li>Terms of service</li>
			<li>Cookie consent</li>
          </ul>
        </div>
        <div class="col-12 col-md min-width">
          <h4>About Us</h4>
          <hr>
          <ul class="list-unstyled larger-text">
            <li>Monday to Saturday: 8:00 - 24:00</li>
            <li>FAQ</li>
            <li>Newsletter</li>
			<li>Our Story</li>
          </ul>
        </div>
        <div class="col-12 col-md min-width">
          <h4>Contact</h4>
          <hr>
		  <ul class="list-unstyled larger-text">
            <li><i class="fas fa-phone"></i> 123-456-7890</li>
            <li><i class="fas fa-envelope"></i> example@example.com</li>
            <li><i class="fas fa-map-marker"></i> 123 Example St.</li>
          </ul>
          <a href="#"><i class="fab fa-facebook fa-2x yellow-icon"></i></a>
          <a href="#"><i class="fab fa-twitter fa-2x yellow-icon"></i></a>
          <a href="#"><i class="fab fa-instagram fa-2x yellow-icon"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.min-width {
  min-width: 350px;
}
.logo {
  max-width: 220px;
}

.larger-text {
  font-size: 1.2em;
}

.yellow-icon {
  color: #FFD700;
}
</style>
</footer>
@stop
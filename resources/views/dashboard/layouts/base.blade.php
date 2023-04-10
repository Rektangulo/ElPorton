@extends('bootstrap')
@section('page')
<body class="bg-dark text-white">
	<nav class="navbar navbar-expand-lg navbar-dark fs-4" style="background-color: #400b96;">
	  <div class="container-fluid">
		<a class="navbar-brand fs-3" href="#">Dashboard</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
		  <ul class="navbar-nav">
			<li class="nav-item dropdown">
			  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				Resources
			  </a>
			  <ul class="dropdown-menu dropdown-menu-dark">
				<li><a class="dropdown-item" href="#">Users</a></li>
				<li><a class="dropdown-item" href="#">Menus</a></li>
				<li><a class="dropdown-item" href="#">Tables</a></li>
			  </ul>
			</li>
			<li class="nav-item">
			  <a class="nav-link me-2" href="#">Home</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link me-2" href="#">Reservations</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link me-2" href="#">Events</a>
			</li>
		  </ul>
		</div>
	  </div>
	</nav>
	@yield('content')
</body>
@stop
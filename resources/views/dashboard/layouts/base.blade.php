<!--base blade for the admin dashboard, with the navbar-->
@extends('bootstrap')
@section('page')
<body class="bg-dark text-white">
	<nav class="navbar navbar-expand-lg navbar-dark fs-4" style="background-color: #400b96;">
	  <div class="container-fluid">
		<a class="navbar-brand fs-3" href="/admin">{{ __('headers.dashboard') }}</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
		  <ul class="navbar-nav d-flex align-items-center">
			<li class="nav-item dropdown">
			  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				{{ __('headers.resources') }}
			  </a>
			  <ul class="dropdown-menu dropdown-menu-dark">
				<li><a class="dropdown-item" href="/admin/users">{{ __('headers.users') }}</a></li>
				<li><a class="dropdown-item" href="/admin/menus">{{ __('headers.menus') }}</a></li>
				<li><a class="dropdown-item" href="/admin/images">{{ __('headers.images') }}</a></li>
				<li><a class="dropdown-item" href="/admin/tags">{{ __('headers.tags') }}</a></li>
				<li><a class="dropdown-item" href="/admin/categories">{{ __('headers.categories') }}</a></li>
			  </ul>
			</li>
			<li class="nav-item">
				<a class="nav-link me-2" href="/">{{ __('headers.home') }}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link me-2" href="/admin/reservations">{{ __('headers.reservations') }}</a>
			</li>
			<li class="nav-item">
				<a class="nav-link me-2" href="/admin/messages">{{ __('headers.messages') }}</a>
			</li>
			<li>
				<x-language-switcher/>
			</li>
		  </ul>
		</div>
	  </div>
	</nav>
	@yield('content')
</body>
@stop
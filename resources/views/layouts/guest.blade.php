<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
		
		<!--custom css-->
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans text-gray-900 antialiased">
		<div class="min-h-screen flex flex-col items-center justify-center bg-darker">
			<div class="mb-6">
				<a href="/">
					<img src="{{ asset('images/logos/logo.png') }}" alt="Logo" class="logo-sm">
				</a>
			</div>
			<div class="w-full sm:max-w-md px-6 py-4 bg-dark shadow-md overflow-hidden">
				{{ $slot }}
			</div>
		</div>
	</body>
</html>

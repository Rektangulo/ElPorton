@extends('bootstrap')
@section('css')
<!--Custom css-->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<style>
	body {
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
	.card {
		border: 2px solid;
		border-image-slice: 1;
		border-image-source: linear-gradient(to right, #8e642b, #f6f6a3, #8e642b);
		background-color: #343a40;
		color: white;
	}
</style>
@stop
@section('page')
<body class="bg-darker text-light"></body>
    <div class="container mx-auto">
        <div class="card h-100 bg-dark text-white text-center rounded-0">
            <div class="card-header fs-5">
                {{ __('front.reservation_confirmed') }}
            </div>
            <div class="card-body">
                <p>{{ __('front.thank_you_name', ['name' => $reservation->name]) }}</p>
                <p>{{ __('front.reservation_details', ['date' => \Carbon\Carbon::parse($reservation->date)->format('d/m/Y'), 'time' => __('front.' . $reservation->time)]) }}</p>
				<p>{{ __('front.phone_reminder') }}</p>
                <p>{{ __('front.looking_forward') }}</p>
            </div>
        </div>
		<div class="text-center m-3">
			<a href="/" class="btn btn-primary rounded-0">{{ __('front.return') }}</a>
		</div>
    </div>
@endsection
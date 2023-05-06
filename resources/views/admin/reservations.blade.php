@extends('admin.layouts.base')
@section('content')

<div class="container" style="width: 80%; padding-top: 30px;">
	<h1 class="text-center mb-4">{{ __('admin.reservations') }}</h1>

	<div class="d-flex justify-content-start mb-3">
		<button class="btn btn-primary me-1 show-all">{{ __('admin.show_all') }} <i class="fas fa-globe"></i></button>
        <button class="btn btn-success mx-1 filter-accepted">{{ __('admin.show_accepted') }} <i class="fas fa-thumbs-up"></i></button>
        <button class="btn btn-danger mx-1 filter-canceled">{{ __('admin.show_canceled') }} <i class="fas fa-thumbs-down"></i></button>
    </div>
	
	<div class="reservation-container">
		@foreach ($reservations as $reservation)
			@include('admin.reservationCard', ['reservation' => $reservation])
		@endforeach
		{{ $reservations->links() }}
	</div>
</div>
@stop

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js"></script>
<script>
	window.translations = {
        accepted: '{{ __('admin.accepted') }}',
        canceled: '{{ __('admin.canceled') }}',
        accept: '{{ __('admin.accept') }}',
        cancel: '{{ __('admin.cancel') }}',
    };
</script>
<script src="{{ asset('js/reservationScript.js') }}"></script>
@stop
@extends('admin.layouts.base')
@section('content')

<div class="container" style="width: 80%; padding-top: 30px;">
	<h1 class="text-center mb-4">{{ __('admin.reservations') }}</h1>

	<div class="d-flex justify-content-start mb-3">
		<button class="btn btn-primary me-1 show-all">{{ __('admin.show_all') }} <i class="fas fa-globe"></i></button>
		<button class="btn btn-secondary mx-1 filter-pending">{{ __('admin.show_pending') }} <i class="fas fa-clock"></i></button>
        <button class="btn btn-success mx-1 filter-accepted">{{ __('admin.show_accepted') }} <i class="fas fa-thumbs-up"></i></button>
        <button class="btn btn-danger mx-1 filter-canceled">{{ __('admin.show_canceled') }} <i class="fas fa-thumbs-down"></i></button>
		<input type="date" class="btn btn-light mx-1" id="search-date">
    	<button class="btn btn-info mx-1 search-by-date">{{ __('admin.search_by_date') }} <i class="fas fa-search"></i></button>
		<button class="btn btn-warning mx-1 reset-date">{{ __('admin.reset_date') }} <i class="fas fa-redo"></i></button>
    </div>
	
	<div class="reservation-container">
		@foreach ($reservations as $reservation)
			@include('admin.reservationCard', ['reservation' => $reservation])
		@endforeach
		<div class="custom-pagination">
			{{ $reservations->links() }}
		</div>
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
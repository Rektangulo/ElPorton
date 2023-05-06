<!--landing for the dashboard, shows messages and reservations-->
@extends('admin.layouts.base')
@section('content')

<div class="container" style="width: 80%; padding-top: 30px;">
	<!--messages-->
	<h2 class="text-left my-3">
		@if ($unreadMessages->isEmpty())
			{{ __('admin.no_unread_messages') }}
		@else
			{{ __('admin.unread_messages') }}
			<span class="badge text-bg-primary">{{ $unreadMessagesCount }}</span>
		@endif
	</h2>
	
	<div class="message-container">
		@foreach ($unreadMessages as $message)
			@include('admin.messageCard', ['message' => $message])
		@endforeach
		{{ $unreadMessages->links() }}
	</div>
	
	<!--reservations-->
	<h2 class="text-left my-3">
		@if ($todaysReservations->isEmpty())
			{{ __('admin.no_reservations_today') }}
		@else
			{{ __('admin.reservations_today') }}
			<span class="badge text-bg-primary">{{ $todaysReservationsCount }}</span>
		@endif
	</h2>

	<div class="reservation-container">
		@foreach ($todaysReservations as $reservation)
			@include('admin.reservationCard', ['reservation' => $reservation])
		@endforeach
		{{ $todaysReservations->links() }}
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/messageScript.js') }}"></script>
<script src="{{ asset('js/reservationScript.js') }}"></script>
@stop
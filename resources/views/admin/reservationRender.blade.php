<div class="reservation-container">
	@foreach ($reservations as $reservation)
		@include('admin.reservationCard', ['reservation' => $reservation])
	@endforeach
	{{ $reservations->links() }}
</div>
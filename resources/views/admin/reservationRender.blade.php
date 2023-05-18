<div class="reservation-container">
    @foreach ($reservations as $reservation)
        @include('admin.reservationCard', ['reservation' => $reservation])
    @endforeach
    <div class="custom-pagination">
        {{ $reservations->links() }}
    </div>
</div>

<style>
	.custom-bg {
		background-color: #474747;
	}
</style>

<div class="card mb-3 custom-bg text-white reservation-card rounded-0" style="height: auto;" data-id="{{ $reservation->id }}">
	<div class="card-body overflow-auto">
		<div class="d-flex justify-content-between">
			<div>
				<h5 class="card-title d-inline mr-3">{{ $reservation->name }}</h5>
				<h5 class="card-title fst-italic d-inline" style="color: gold;">{{ $reservation->date }} {{ $reservation->time }}</h5>
			</div>
			<div>
				<h5 class="card-title">{{ $reservation->created_at }}</h5>
			</div>
		</div>
		<div class="reservation-details m-3" style="display: none;">
			<p class="card-text">{{ $reservation->number }}</p>
			<p class="card-text">{{ $reservation->email }}</p>
			<p class="card-text">{{ $reservation->message }}</p>
		</div>
		<div class="d-flex justify-content-end">
			<button class="btn btn-success mx-1 reservation-details reservation" {{ $reservation->status === 'accepted' ? ' disabled' : '' }} style="display: none;"><i class="fas fa-check"></i> {{ $reservation->status === 'accepted' ? __('admin.accepted') : __('admin.accept') }}</button>
            <button class="btn btn-danger mx-1 reservation-details reservation" {{ $reservation->status === 'canceled' ? ' disabled' : '' }} style="display: none;"><i class="fas fa-times"></i> {{ $reservation->status === 'canceled' ? __('admin.canceled') : __('admin.cancel') }}</button>
		</div>
	</div>
</div>
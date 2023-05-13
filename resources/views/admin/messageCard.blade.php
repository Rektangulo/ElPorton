<style>
	.custom-bg {
		background-color: #474747;
	}
</style>

<div class="card mb-3 custom-bg text-white card-hover rounded-0" style="height: auto;" data-id="{{ $message->id }}">
	<div class="card-body overflow-auto">
		<div class="d-flex justify-content-between">
			<div>
				<h5 class="card-title d-inline mr-3">{{ $message->name }}</h5>
				<h5 class="card-title fst-italic d-inline" style="color: gold;">{{ $message->reason }}</h5>
			</div>
			<div>
				<h5 class="card-title">{{ $message->created_at }}</h5>
			</div>
		</div>
		<div class="message-details m-3" style="display: none;">
			<p class="card-text">{{ $message->email }}</p>
			<p class="card-text">{{ $message->number }}</p>
			<p class="card-text">{{ $message->message }}</p>
		</div>
		<div class="d-flex justify-content-end">
			<button class="btn mx-1 mark-as-important message-details {{ $message->important ? 'btn-warning' : 'btn-secondary' }}" style="display: none;"><i class="fas fa-star"></i></button>
			<button class="btn mx-1 mark-as-read message-details {{ $message->read ? 'btn-secondary	' : 'btn-primary' }}" style="display: none;"><i class="fas {{ $message->read ? 'fa-envelope-open' : 'fa-envelope' }}"></i></button>
			<button class="btn mx-1 delete-message message-details {{ $message->trashed() ? 'btn-success' : 'btn-danger' }}" style="display: none;">
				<i class="fas {{ $message->trashed() ? 'fa-trash-restore' : 'fa-trash' }}"></i>
				{{ $message->trashed() ? __('admin.restore') : __('admin.delete') }}
			</button>
		</div>
	</div>
</div>
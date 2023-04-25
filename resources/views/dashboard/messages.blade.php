@extends('dashboard.layouts.base')
@section('content')

<div class="container" style="width: 80%; padding-top: 30px;">
	<h1 class="text-center mb-4">{{ __('headers.messages') }}</h1>

	<div class="d-flex justify-content-start mb-3">
		<button class="btn btn-primary me-1 show-all">Show All <i class="fas fa-star"></i></button>
        <button class="btn btn-warning mx-1 filter-important">Show Important <i class="fas fa-star"></i></button>
        <button class="btn btn-success mx-1 filter-read">Show Read <i class="fas fa-envelope-open"></i></button>
        <button class="btn btn-danger mx-1 show-deleted">Show Deleted <i class="fas fa-trash"></i></button>
    </div>
	
	<div class="message-container">
		@foreach ($messages as $message)
			@include('dashboard.messageCard', ['message' => $message])
		@endforeach
		{{ $messages->links() }}
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js"></script>
<script src="{{ asset('js/messageScript.js') }}"></script>
@stop
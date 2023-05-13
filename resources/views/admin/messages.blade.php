@extends('admin.layouts.base')
@section('content')

<div class="container" style="width: 80%; padding-top: 30px;">
	<h1 class="text-center mb-4">{{ __('admin.messages') }}</h1>

	<div class="d-flex justify-content-start mb-3">
		<button class="btn btn-primary me-1 show-all">{{ __('admin.show_all') }} <i class="fas fa-globe"></i></button>
        <button class="btn btn-warning mx-1 filter-important">{{ __('admin.show_important') }} <i class="fas fa-star"></i></button>
        <button class="btn btn-success mx-1 filter-read">{{ __('admin.show_read') }} <i class="fas fa-envelope-open"></i></button>
        <button class="btn btn-danger mx-1 show-deleted">{{ __('admin.show_deleted') }} <i class="fas fa-trash"></i></button>
    </div>
	
	<div class="message-container">
		@foreach ($messages as $message)
			@include('admin.messageCard', ['message' => $message])
		@endforeach
		{{ $messages->links() }}
	</div>
</div>
@stop
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    window.restoreText = '<?php echo __('admin.restore'); ?>';
    window.deleteText = '<?php echo __('admin.delete_icon'); ?>';
</script>
<script src="{{ asset('js/messageScript.js') }}"></script>
@stop
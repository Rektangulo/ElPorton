<!--
	receives the following variables:
		- 'title': page title
		- 'data' => the resources to show, using all() or similar
		- 'headers' => array with the table headers without the action buttons,
-->
@extends('admin.layouts.base')
@section('css')
<style>
    td {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@stop
@section('content')
<div style="padding-top: 30px;">
	<h1 class="text-center mb-4">{{$title}}</h1>
	@if (session('success'))
		<div class="alert alert-success mb-0 rounded-0 mb-4">
			{{ session('success') }}
		</div>
	@endif
	<div class="table-responsive">
		<table class="table table-dark table-hover table-striped text-center fs-5" style="width: 90%; margin: auto;">
			<thead>
				<tr>
					<th colspan="{{ count($headers) + 1 }}">
						<form method="GET" action="{{ url(request()->path()) }}" class="d-flex justify-content-end">
							<input type="text" name="search" placeholder="Search..." class="form-control me-2">
							<button type="submit" class="btn btn-outline-success me-2">{{ __('admin.search') }}</button>
							<a href="{{ url(request()->path()) }}" class="btn btn-outline-danger">{{ __('admin.reset') }}</a>
						</form>
					</th>
				</tr>
				<tr>
					@foreach ($headers as $header)
						<th>{{ __('admin.'.$header) }}</th>
					@endforeach
					<th>{{ __('admin.actions') }}</th>
				</tr>
			</thead>
			<tbody class="table-group-divider">
				@foreach ($data as $row)
					<tr data-href="{{ url(request()->path().'/'.$row['id']) }}">
						@foreach ($headers as $header)
							<td>
								@if ($header === 'image_id')
									{{ $row['image'] ? $row['image']->name : '' }}
								@elseif ($header === 'recommended')
									{{ $row[$header] ? __('admin.yes') : __('admin.no') }}
								@elseif ($header === 'category_id')
									{{ $row['category'] ? $row['category']->name : '' }}
								@else
									{{ $row[$header] }}
								@endif
							</td>
						@endforeach
						<td>
							<a class="btn btn-warning" href="{{ url(request()->path(). '/' . $row['id'] .'/edit') }}"><i class="fas fa-pencil-alt"></i></a>

							<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $row['id'] }}"><i class="fas fa-trash"></i></button>

							<!-- Modal -->
							<div class="modal fade" id="deleteModal{{ $row['id'] }}">
								<div class="modal-dialog">
									<div class="modal-content bg-dark text-white">
										<div class="modal-header">
											<h5 class="modal-title" id="deleteModalLabel{{$row['id']}}">{{ __('admin.delete') }} {{ $row['name'] }}</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
										</div>
										<div class="modal-body">
											{{ __('admin.confirm_delete') }}
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('admin.cancel') }}</button>
											<form action="{{ url(request()->path(). '/' . $row['id']) }}" method="POST">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger">{{ __('admin.delete') }}</button>
											</form>
										</div>
									</div>
								</div>
							</div>

						</td>
					</tr>
				@endforeach

				<!--add button-->
				<tr data-href="{{ url(request()->path().'/create') }}">
					<td colspan="{{count($headers)+1}}" align="center">
						<a href="{{ url(request()->path().'/create') }}" class="btn btn-success">{{ __('admin.create_new') }}<i class="fas fa-plus-square"></i></a>
					</td>
				</tr>

			</tbody>
		</table>
	</div>
	<div class="d-flex justify-content-center my-4">
		{{ $data->links() }}
	</div>
</div>
@stop
@section('scripts')
<!--clickable rows, disabled on action buttons and when the modal is showing-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$('table').on('click', 'tbody tr', function(event) {
    if (!$(event.target).closest('button').hasClass('btn') && $('.modal.show').length === 0 && !$(event.target).hasClass('modal')) {
        window.location.href = $(this).data('href');
    }
	});
</script>
@stop
@extends('dashboard.layouts.base')
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
@section('content')
<div <div style="padding-top: 2%;">
	<h1 class="text-center mb-4">{{$title}}</h1>
	<table class="table table-dark table-hover table-striped text-center fs-5" style="width: 90%; margin: auto;">
		<thead>
			<tr>
				@foreach ($headers as $header)
					<th>{{ __('headers.'.$header) }}</th>
				@endforeach
				<th>{{ __('headers.actions') }}</th>
			</tr>
		</thead>
		<tbody class="table-group-divider">
			@foreach ($data as $row)
				<tr>
					@foreach ($headers as $header)
						<td>{{ $row[$header] }}</td>
					@endforeach
					<td>
						<a class="btn btn-warning" href="{{ str_replace('__id__', $row['id'], $editUrl) }}"><i class="fas fa-pencil-alt"></i></a>
						<!--<a class="btn btn-danger" href="{{ str_replace('__id__', $row['id'], $deleteUrl) }}">Delete</a>-->
						
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $row['id'] }}"><i class="fas fa-trash"></i></button>
						
						<!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $row['id'] }}">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{$row['id']}}">Delete {{ $row['name'] }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ str_replace('__id__', $row['id'], $deleteUrl) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
											<button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
						
					</td>
				</tr>
			@endforeach
			
			<!--add button-->
			<tr>
				<td colspan="{{count($headers)+1}}" align="center">
					<a href="{{ $createUrl }}" class="btn btn-success">Create New <i class="fas fa-plus-square"></i></a>
				</td>
			</tr>
			
		</tbody>
	</table>
</div>
@stop
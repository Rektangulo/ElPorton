<!--
	show and edit blade, uses 'disabled' to swap between them.
	receives the following variables:
		- 'resource': the resource to show, using Resource::find($id)
		- 'resourceType': the name of the resource, to build the action
		- 'nextRoute': controller@method
		- 'returnRoute': index of the resource
-->
@extends('dashboard.layouts.base')
@section('content')
<div class="container bg-dark text-white" style="padding-top: 30px;">
	@empty($disabled)
		<h1 class="text-center mb-4">{{ __('headers.edit_resource') }}</h1>
	@else
		<h1 class="text-center mb-4">{{ __('headers.view_resource') }}</h1>
	@endempty
    <form action="{{ action($nextRoute, [$resourceType => $resource->id]) }}" method="POST" class="mb-3">
		@method('PUT')
        @csrf
        @foreach ($resource->getAttributes() as $attribute => $value)
            @if (!in_array($attribute, ['id', 'created_at', 'updated_at']))
                <div class="form-group mb-4">
                    <label class="fs-5" for="{{ $attribute }}">{{ ucfirst(__('headers.'.$attribute)) }}</label>
					<input type="text" id="{{ $attribute }}" name="{{ $attribute }}" value="{{ $value }}" class="form-control form-control-lg" @isset($disabled) disabled @endisset>
                </div>
            @endif
        @endforeach
        <div class="d-flex justify-content-center">
			@empty($disabled)
            	<button type="submit" class="btn btn-primary" style="margin-right: 20px;">{{ __('headers.save') }}</button>
			@endempty
            <a href="{{ $returnRoute }}" class="btn btn-secondary">{{ __('headers.return') }}</a>
        </div>
    </form>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@stop
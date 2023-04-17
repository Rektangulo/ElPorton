<!--
	create blade, receives the following variables:
		- 'attributes': the fields to show
		- 'resourceType': the name of the resource, to build the action
		- 'nextRoute': controller@method
		- 'returnRoute': index of the resource
		- 'images': list of all image models
-->
@extends('dashboard.layouts.base')
@section('content')
<div class="container bg-dark text-white" style="padding-top: 30px;">
    <h1 class="text-center mb-4">{{ __('headers.create_resource') }}</h1>
    <form action="{{ action($nextRoute) }}" method="POST" class="mb-3" enctype="multipart/form-data">
        @csrf
        @foreach ($attributes as $attribute)
            @if (!in_array($attribute, ['id', 'created_at', 'updated_at']))
                <div class="form-group mb-4">
                    <label class="fs-5" for="{{ $attribute }}">{{ ucfirst(__('headers.'.$attribute)) }}</label>
					
					
					@if ($attribute === 'image_id')
						<!--Shows the name if its disabled, shows the select or upload if not-->
						<div class="input-group">
							<select id="image" name="selected-image" class="form-select fs-5">
								<option value="">{{ __('headers.select_prompt') }}</option>
								@foreach ($images as $image)
									<option value="{{ $image->id }}" {{ $image->id == old('selected-image') ? 'selected' : '' }}>{{ $image->name }}</option>
								@endforeach
							</select>
							<label class="input-group-text" for="image-upload">or upload</label>
							<input type="file" id="image-upload" name="image" class="form-control">
						</div>
					@else
						<input type="text" id="{{ $attribute }}" name="{{ $attribute }}" value="{{ old($attribute) }}" class="form-control form-control-lg">
					@endif
                </div>
            @endif
        @endforeach
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary" style="margin-right: 20px;">{{ __('headers.save') }}</button>
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
			@if (old('image'))
				<li>{{ __('headers.file_error') }}</li>
			@endif
        </ul>
    </div>
@endif
@stop
<!--
	show and edit blade, uses 'disabled' to swap between them.
	receives the following variables:
		- 'resource': the resource to show, using Resource::find($id)
		- 'resourceType': the name of the resource, to build the action
		- 'nextRoute': controller@method
		- 'returnRoute': index of the resource
		- 'images': list of all image models
-->
@extends('dashboard.layouts.base')
@section('content')

<div class="container bg-dark text-white" style="padding-top: 30px;">
	@empty($disabled)
		<h1 class="text-center mb-4">{{ __('headers.edit_resource') }}</h1>
	@else
		<h1 class="text-center mb-4">{{ __('headers.view_resource') }}</h1>
	@endempty
    <form action="{{ action($nextRoute, [$resourceType => $resource->id]) }}" method="POST" enctype="multipart/form-data" class="mb-3">
		@method('PUT')
        @csrf
        @foreach ($resource->getAttributes() as $attribute => $value)
            @if (!in_array($attribute, ['id', 'created_at', 'updated_at', 'image']))
				<div class="form-group mb-4">
					<label class="fs-5" for="{{ $attribute }}">{{ __('headers.'.$attribute) }}</label>
					@if ($attribute === 'image_id')
						<!--Shows the name if its disabled, shows the select or upload if not-->
						@isset($disabled)
							<input type="text" id="{{ $attribute }}" name="{{ $attribute }}" value="{{ $resource->image ? $resource->image->name : '' }}" class="form-control form-control-lg" @isset($disabled) disabled @endisset>
						@else
							<div class="input-group" @isset($disabled) hidden="true" @endisset>
								<!--if there is no images only the file prompt will be shown-->
								@isset($images)
									<select id="image" name="selected-image" class="form-select fs-5">
										<option value="">{{ __('headers.select_prompt') }}</option>
										@foreach ($images as $image)
											<option value="{{ $image->id }}" {{ $image->id == old('selected-image', $value) ? 'selected' : '' }}>{{ $image->name }}</option>
										@endforeach
									</select>
									<label class="input-group-text" for="image-upload">or upload</label>
								@endisset
								<input type="file" id="image-upload" name="image" class="form-control">
							</div>
						@endisset
					@else
						<input type="text" id="{{ $attribute }}" name="{{ $attribute }}" value="{{ $value }}" class="form-control form-control-lg" @isset($disabled) disabled @endisset>
					@endif
				</div>
			@endif
        @endforeach
		<!--special case for Image models-->
		@if ($resource->image_id)
			<div class="d-flex justify-content-center my-3">
				<img src="{{ asset('images/' . $resource->image->image) }}" class="img-fluid rounded" alt="Resource image">
			</div>
		<!--image models use this one-->
		@elseif ($resource->image)
			<div class="d-flex justify-content-center my-3">
				<img src="{{ asset('images/' . $resource->image) }}" class="img-fluid rounded" alt="Resource image">
			</div>
		@endif
        <div class="d-flex justify-content-center">
			@empty($disabled)
            	<button type="submit" class="btn btn-primary" style="margin-right: 20px;">{{ __('headers.save') }}</button>
			@else
				<a href="{{$resource->id . "/edit"}}" class="btn btn-warning" style="margin-right: 20px;">{{ __('headers.edit') }}</a>
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
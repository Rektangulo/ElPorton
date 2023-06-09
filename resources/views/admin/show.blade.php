<!--
	show and edit blade, uses 'disabled' to swap between them.
	receives the following variables:
		- 'resource': the resource to show, using Resource::find($id)
		- 'resourceType': the name of the resource, to build the action
		- 'nextRoute': controller@method
		- 'showTags': show tag html
-->
@extends('admin.layouts.base')
@section('content')

<div class="container bg-dark text-white" style="padding-top: 30px;">
	@empty($disabled)
		<h1 class="text-center mb-4">{{ __('admin.edit_resource') }}</h1>
	@else
		<h1 class="text-center mb-4">{{ __('admin.view_resource') }}</h1>
	@endempty
    <form action="{{ action($nextRoute, [$resourceType => $resource->id]) }}" method="POST" enctype="multipart/form-data" class="mb-3">
		@method('PUT')
        @csrf
		
		<!--shows the attributes-->
        @foreach ($resource->getAttributes() as $attribute => $value)
            @if (!in_array($attribute, ['id', 'created_at', 'updated_at', 'image']))
				<div class="form-group mb-4">
					@if ($attribute != 'recommended')
						<label class="fs-5" for="{{ $attribute }}">{{ __('admin.'.$attribute) }}</label>
					@endif
					<!--images-->
					@if ($attribute === 'image_id')
						<!--Shows the name if its disabled, shows the select or upload if not-->
						@isset($disabled)
							<input type="text" id="{{ $attribute }}" name="{{ $attribute }}" value="{{ $resource->image ? $resource->image->name : '' }}" class="form-control form-control-lg" @isset($disabled) disabled @endisset>
						@else
							<div class="input-group" @isset($disabled) hidden="true" @endisset>
								<!--if there is no images only the file prompt will be shown-->
								@isset($images)
									<select id="image" name="selected-image" class="form-select fs-5">
										<option value="">{{ __('admin.select_prompt') }}</option>
										@foreach ($images as $image)
											<option value="{{ $image->id }}" {{ $image->id == old('selected-image', $value) ? 'selected' : '' }}>{{ $image->name }}</option>
										@endforeach
									</select>
									<label class="input-group-text" for="image-upload">{{ __('admin.or_upload') }}</label>
								@endisset
								<input type="file" id="image-upload" name="image" class="form-control">
							</div>
						@endisset
					
					<!--description-->
					@elseif ($attribute === 'description')
						<textarea id="{{ $attribute }}" name="{{ $attribute }}" rows="5" class="form-control form-control-lg" @isset($disabled) disabled @endisset>{{ old($attribute, $value) }}</textarea>
					
					<!--category-->
					@elseif ($attribute === 'category_id')
						<select id="{{ $attribute }}" name="{{ $attribute }}" class="form-select form-select-lg" @isset($disabled) disabled @endisset>
							@if(isset($disabled) && $resource->category_id === null)
								<option value="">{{ __('admin.none') }}</option>
							@endif
							<option value="">{{ __('admin.select_prompt') }}</option>
							@foreach ($categories as $category)
								<option value="{{ $category->id }}" {{ $category->id == old($attribute, $value) ? 'selected' : '' }}>{{ $category->name }}</option>
							@endforeach
						</select>
					
					<!--recommended menu-->
					@elseif ($attribute === 'recommended')
						<input type="checkbox" id="{{ $attribute }}" name="{{ $attribute }}" class="btn-check" {{ old($attribute, $resource->recommended) ? 'checked' : '' }} @isset($disabled) disabled @endisset>
						<label class="btn btn-outline-primary fs-4" for="{{ $attribute }}">{{ $attribute }}</label>
					
					<!--default text-->
					@else
						<input type="text" id="{{ $attribute }}" name="{{ $attribute }}" value="{{ $value }}" class="form-control form-control-lg" @isset($disabled) disabled @endisset>
					@endif
				</div>
			@endif
        @endforeach
		
		<!--tag section-->
		@isset($showTags)
			<label for="tags" class="form-label fs-5">{{ __('admin.tags:') }}</label>
			@empty($disabled)
				<select name="tags[]" id="tags" multiple class="form-select mb-3" size="6">
					@foreach ($tags as $tag)
						<option value="{{ $tag->id }}">{{ $tag->name }}</option>
					@endforeach
				</select>
			@endempty
			<div id="selected-tags">
				@foreach ($resource->tags->sortBy('id') as $tag)
					<span class="badge bg-primary me-1 fs-5" data-value="{{ $tag->id }}">{{ $tag->name }}
						@empty($disabled)
							<i class="fas fa-minus-circle ms-1"></i>
						@endempty
					</span>
					<input type="hidden" name="tags[]" value="{{ $tag->id }}">
				@endforeach
			</div>
		@endisset
		
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
            	<button type="submit" class="btn btn-primary" style="margin-right: 20px;">{{ __('admin.save') }}</button>
			@else
				<a href="{{$resource->id . "/edit"}}" class="btn btn-warning" style="margin-right: 20px;">{{ __('admin.edit') }}</a>
			@endempty
            <a href="{{ session('previousUrl', '/default-url') }}" class="btn btn-secondary">{{ __('admin.return') }}</a>
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

<!--makes the tag work-->
<script>
	document.querySelector('#tags').addEventListener('dblclick', event => {
		if (event.target.tagName === 'OPTION') {
			let tagId = event.target.value;
			let tagName = event.target.textContent;

			// Check if tag is already selected
			let selectedTags = document.querySelectorAll('#selected-tags .badge');
			let tagAlreadySelected = Array.from(selectedTags).some(tag => tag.getAttribute('data-value') === tagId);
			if (tagAlreadySelected) {
				return;
			}

			// Create badge element
			let tagElement = document.createElement('span');
			tagElement.classList.add('badge', 'bg-primary', 'me-1', 'fs-5');
			tagElement.setAttribute('data-value', tagId);
			tagElement.innerHTML = `${tagName} ${!{{ json_encode(isset($disabled) ? $disabled : false) }} ? '<i class="fas fa-minus-circle ms-1"></i>' : ''}`;
			document.querySelector('#selected-tags').appendChild(tagElement);

			// Create hidden input element
			let inputElement = document.createElement('input');
			inputElement.type = 'hidden';
			inputElement.name = 'tags[]';
			inputElement.value = tagId;
			document.querySelector('#selected-tags').appendChild(inputElement);

			// Add event listener to remove tag when clicked
			if (!{{ json_encode(isset($disabled) ? $disabled : false) }}) {
				tagElement.addEventListener('click', () => {
					tagElement.remove();
					inputElement.remove();
				});
			}
		}
	});

	// Add event listeners to existing badges
	document.querySelectorAll('#selected-tags .badge').forEach(badge => {
		badge.addEventListener('click', () => {
			badge.remove();
			let inputElement = document.querySelector(`input[name="tags[]"][value="${badge.getAttribute('data-value')}"]`);
			if (inputElement) {
				inputElement.remove();
			}
		});
	});
</script>
@stop
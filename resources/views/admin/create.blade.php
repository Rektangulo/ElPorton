<!--
	create blade, receives the following variables:
		- 'attributes': the fields to show
		- 'resourceType': the name of the resource, to build the action
		- 'nextRoute': controller@method
		- 'images': list of all image models
-->
@extends('admin.layouts.base')
@section('content')
<div class="container bg-dark text-white" style="padding-top: 30px;">
    <h1 class="text-center mb-4">{{ __('admin.create_resource') }}</h1>
    <form action="{{ action($nextRoute) }}" method="POST" class="mb-3" enctype="multipart/form-data">
        @csrf
		
		<!--shows the attributes-->
        @foreach ($attributes as $attribute)
            @if (!in_array($attribute, ['id', 'created_at', 'updated_at']))
                <div class="form-group mb-4">
					@if ($attribute != 'recommended')
                    	<label class="fs-5" for="{{ $attribute }}">{{ ucfirst(__('admin.'.$attribute)) }}</label>
					@endif
					<!--images-->
					@if ($attribute === 'image_id')
						<!--Shows the name if its disabled, shows the select or upload if not-->
						<div class="input-group">
							<!--if there is no images only the file prompt will be shown-->
							@isset($images)
								<select id="image" name="selected-image" class="form-select fs-5">
									<option value="">{{ __('admin.select_prompt') }}</option>
									@foreach ($images as $image)
										<option value="{{ $image->id }}" {{ $image->id == old('selected-image') ? 'selected' : '' }}>{{ $image->name }}</option>
									@endforeach
								</select>
							<label class="input-group-text" for="image-upload">{{ __('admin.or_upload') }}</label>
							@endisset
							<input type="file" id="image-upload" name="image" class="form-control">
						</div>
					
					<!--description-->
					@elseif ($attribute === 'description')
						<textarea id="{{ $attribute }}" name="{{ $attribute }}" rows="5" class="form-control form-control-lg">{{ old($attribute) }}</textarea>
					
					<!--category-->
					@elseif ($attribute === 'category_id')
						<select id="{{ $attribute }}" name="{{ $attribute }}" class="form-select form-select-lg">
							<option value="">{{ __('admin.select_prompt') }}</option>
							@foreach (\App\Models\Category::all() as $category)
								<option value="{{ $category->id }}" {{ $category->id == old($attribute) ? 'selected' : '' }}>{{ $category->name }}</option>
							@endforeach
						</select>
					
					<!--recommended menu-->
					@elseif ($attribute === 'recommended')
						<input type="checkbox" id="{{ $attribute }}" name="{{ $attribute }}" class="btn-check" {{ old($attribute) ? 'checked' : '' }}>
						<label class="btn btn-outline-primary fs-4" for="{{ $attribute }}">{{ $attribute }}</label>
					
					<!--default text-->
					@else
						<input type="text" id="{{ $attribute }}" name="{{ $attribute }}" value="{{ old($attribute) }}" class="form-control form-control-lg">
					@endif
                </div>
            @endif
        @endforeach
		
		<!--tag section-->
		@isset($showTags)
			<label for="tags" class="form-label fs-5">{{ __('admin.tags:') }}</label>
			<select name="tags[]" id="tags" multiple class="form-select mb-3" size="6">
				@foreach ($tags as $tag)
					<option value="{{ $tag->id }}">{{ $tag->name }}</option>
				@endforeach
			</select>

			<div id="selected-tags"></div>
		@endisset
		
		<!--buttons-->
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary" style="margin-right: 20px;">{{ __('admin.save') }}</button>
            <a href="{{ session('previousUrl', '/default-url') }}" class="btn btn-secondary">{{ __('admin.return') }}</a>
        </div>
    </form>
</div>

<!--errors-->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
			@if (old('image'))
				<li>{{ __('admin.file_error') }}</li>
			@endif
        </ul>
    </div>
@endif

<!--makes the tags work-->
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
			tagElement.classList.add('badge', 'bg-primary', 'me-1', 'mb-3', 'fs-5');
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
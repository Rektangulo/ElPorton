@php
    $currentLocale = app()->getLocale();
@endphp

@extends('bootstrap')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<!--Custom css-->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<style>
	.datepicker {
		background-color: #171717;
		color: #fff;
		border: 2px solid;
		border-image-slice: 1;
		border-image-source: linear-gradient(to right, #8e642b, #f6f6a3, #8e642b);
	}
	.datepicker table tr td.day:hover,
	.datepicker table tr td.focused,
	.datepicker .prev:hover,
	.datepicker .next:hover,
	.datepicker-months .month:hover,
	.datepicker .datepicker-switch:hover {
		color: #000;
	}
	
	.form-control {
		border: 2px solid;
		border-image-slice: 1;
		border-image-source: linear-gradient(to right, #8e642b, #f6f6a3, #8e642b);
		background-color: #343a40;
		color: white;
	}
	
	.datepicker table {
		width: 100%;
	}

	.datepicker {
		width: 350px;
	}

	.datepicker table tr td,
	.datepicker table tr th {
		width: auto;
		height: auto;
		font-size: 1.2rem;
		padding: 0.3rem;
	}

	form {
		width: 50%;
		margin: 0 auto;
	}
	input::placeholder,
	select {
		color: darkgray !important;
	}

	input:focus,
	select:focus {
		color: white !important;
		background-color: #343a40 !important;
	}
    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
</style>
@stop
@section('page')
<body class="bg-darker text-light"></body>

<!--form-->
<div class="container form-container">
    <h2 class="text-center mb-4">{{ __('front.reservation_title') }}</h2>
    <form action="/check-date" method="post" class="mx-auto">
        @csrf
        <div class="form-group mb-3 d-flex justify-content-center">
            <div id="datepicker"></div>
            <input type="hidden" name="date" id="date">
        </div>
        <div class="form-group mb-3 d-flex justify-content-center">
            <small class="form-text text-white">{{ __('front.date_disclaimer') }}</small>
        </div>
        <div class="form-group mb-3">
            <select name="time" id="time" class="form-control rounded-0" required>
                <option value="" disabled selected>{{ __('front.time_label') }}</option>
                <option value="lunch">{{ __('front.time_lunch') }}</option>
                <option value="dinner">{{ __('front.time_dinner') }}</option>
            </select>
        </div>
        <div class="form-group mb-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary rounded-0">{{ __('front.send_button') }}</button>
        </div>
    </form>
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
</div>
@stop

@section('scripts')
<!-- Add the necessary JavaScript to initialize the datepicker -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
@if ($currentLocale === 'es')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
@elseif ($currentLocale === 'en')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.en-GB.min.js"></script>
@endif
<script>
    $(document).ready(function(){
		var startDate = new Date();
		startDate.setDate(startDate.getDate() + 1); // Set start date to 24 hours from now

		var endDate = new Date();
		endDate.setMonth(endDate.getMonth() + 2); // Set end date to 2 months from now

		var initialDate = '{{ old('date') }}' || startDate;
		var startView = '{{ old('date') }}' ? 0 : 1;
		
		$('#datepicker').datepicker({
            format: 'dd/mm/yyyy',
            startDate: startDate,
            endDate: endDate,
            startView: startView,
            maxViewMode: 1,
            language: '{{ $currentLocale }}'
        }).datepicker('setDate', initialDate).on('changeDate', function(e) {
            $('#date').val(e.format());
        });
	});
	if ('{{ old('date') }}') {
        $('#date').val('{{ old('date') }}');
    }
	window.addEventListener('DOMContentLoaded', function() {
        var timeSelect = document.getElementById('time');
        timeSelect.value = '{{ old('time') }}';
    });
</script>
@stop
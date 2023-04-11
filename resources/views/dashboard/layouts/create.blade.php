<!--
	create blade, receives the following variables:
		- 'attributes': the fields to show
		- 'resourceType': the name of the resource, to build the action
		- 'nextRoute': controller@method
		- 'returnRoute': index of the resource
-->
@extends('dashboard.layouts.base')
@section('content')
<div class="container bg-dark text-white" style="padding-top: 30px;">
    <h1 class="text-center mb-4">{{ __('headers.create_resource') }}</h1>
    <form action="{{ action($nextRoute) }}" method="POST" class="mb-3">
        @csrf
        @foreach ($attributes as $attribute)
            @if (!in_array($attribute, ['id', 'created_at', 'updated_at']))
                <div class="form-group mb-4">
                    <label class="fs-5" for="{{ $attribute }}">{{ ucfirst(__('headers.'.$attribute)) }}</label>
                    <input type="text" id="{{ $attribute }}" name="{{ $attribute }}" value="{{ old($attribute) }}" class="form-control form-control-lg">
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
        </ul>
    </div>
@endif
@stop
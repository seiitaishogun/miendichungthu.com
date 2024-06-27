@extends('admin') @section('page_header')

<div class="pull-right">
	<a href="{{ route('admin.customer.index') }}" class="btn btn-default">
		<i class="fa fa-arrow-circle-left"></i> {{ trans('language.back') }}
	</a>
	<button type="button" class="btn btn-primary"
		onclick="submitForm('#customer_edit');">
		<i class="fa fa-save"></i> {{ trans('language.save') }}
	</button>
</div>

<h1>{{ $title }}</h1>
@stop @section('content') {!! Form::open([ 'url' =>
admin_route('customer.update', $customer->id), 'method' => 'PUT',
'class' => 'form-validate', 'id' => 'customer_edit', 'enctype' =>
'multipart/form-data', 'data-callback' => 'nothing_to_do' ]) !!}
@include('customer::admin.form') {!! Form::close() !!} @stop

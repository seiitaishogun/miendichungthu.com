@extends('admin') @section('page_header')

<div class="pull-right">
	<a href="{{ route('admin.customer.address.index', $customer->id) }}"
		class="btn btn-default"> <i class="fa fa-arrow-circle-left"></i> {{
		trans('language.back') }}
	</a>
	<button type="button" class="btn btn-primary"
		onclick="submitForm('#customer_create');">
		<i class="fa fa-save"></i> {{ trans('language.save') }}
	</button>
</div>

<h1>{{ $title }}</h1>
@stop @section('content') {!! Form::open([ 'url' =>
admin_route('customer.address.store', $customer->id), 'method' =>
'POST', 'class' => 'form-validate', 'id' => 'customer_create', 'enctype'
=> 'multipart/form-data', ]) !!}
@include('customer::admin.address.form') {!! Form::close() !!} @stop

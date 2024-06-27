@extends('admin') @section('page_header')

@can('customer.address.create')
<div class="pull-right">
	<a href="{{ admin_route('customer.address.create', $customer->id) }}"
		class="btn btn-primary"> <i class="fa fa-plus"></i> {{
		trans('language.create') }}
	</a>
</div>
@endcan

<h1>{{ $title }}</h1>
@stop @section('content') @component('components.block') @slot('title',
trans('customer::language.customer_list')) @include('partial.datatable')
@endcomponent @stop

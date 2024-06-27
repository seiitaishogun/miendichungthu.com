@extends('admin') @section('page_header')

<div class="pull-right">
	{{-- @can('customer.group.index') <a
		href="{{ admin_route('customer.group.index') }}" class="btn btn-info">
		<i class="fa fa-users"></i> Nhóm khách hàng
	</a> @endcan @can('customer.source.index') <a
		href="{{ admin_route('customer.source.index') }}"
		class="btn btn-warning"> <i class="fa fa-address-card-o"></i> Nguồn
		khách hàng
	</a> @endcan  --}}
	<a href="{{ url()->to('/customer/export') }}/{{session('lang')}}" target="_blank" id='btn-export' class="btn btn-default"> 
		<i class="fa fa-file-text-o"></i> {{ trans('language.export') }}
	</a>
	@can('customer.customer.create') <a
		href="{{ admin_route('customer.create') }}" class="btn btn-primary"> <i
		class="fa fa-plus"></i> {{ trans('language.create') }}
	</a> @endcan
</div>

<h1>{{ $title }}</h1>
@stop @section('content')

@if(allow('customer.group.index') || allow('customer.source.index'))
<div class="row block full" style="margin-bottom: 30px">
	<div class="col-md-6 col-md-offset-6 text-right">
		<form action="{{ request()->url() }}" method="GET" id="filter">
			<div class="row">
			@if(allow('customer.group.index'))
			<div class="col-md-6">
				<div class="form-group">
					<select name="group" onchange="getElementById('filter').submit();"
						class="form-control">
						<option value="0">Tất cả các nhóm</option>
						@foreach(\Modules\Customer\Models\Group::all() as $group)
						<option value="{{ $group->id }}" {{ request('group') == $group->id
							? 'selected' : '' }}>{{ $group->name }}</option> @endforeach
					</select>
				</div>
			</div>
			@endif
		@if(allow('customer.source.index'))
		<div class="col-md-6">
			<div class="form-group">
				<select name="source"
				onchange="getElementById('filter').submit();"
				class="form-control">
					<option value="0">Tất cả các nguồn</option>
					@foreach(\Modules\Customer\Models\Source::all() as $source)
					<option value="{{ $source->id }}" {{ request('source') ==
						$source->id ? 'selected' : '' }}>{{ $source->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
		@endif
</div>
</form>
</div>
</div>
@endif

@component('components.block') @slot('title',
trans('customer::language.customer_list')) @include('partial.datatable')
@endcomponent @stop


@push('footer')
<div class="modal fade" id="data" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">Information</h4>
</div>
<div class="modal-body"></div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var showData = function (id) {
	$('.modal-body').html('');

	$.get('{{ request()->url() }}?id=' + id, function (data) {
		$('.modal-body').html(data);
		$('#data').modal('show');
	});
}

@if(request()->has('customer'))
showData({{ request()->get('customer') }});
@endif
</script>
@endpush
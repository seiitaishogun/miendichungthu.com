<div class="row">
	<div class="col-lg-12">
		@component('components.block') @slot('title', 'Nhóm thành viên')
		<div class="form-horizontal form-bordered">
			<div class="form-group">
				{!! Form::label('name', 'Tên nhóm', ['class' => 'col-md-3
				control-label']) !!}
				<div class="col-md-6">{!! Form::text('name', $group->name, ['class'
					=> 'form-control', 'required']) !!}</div>
			</div>
		</div>
		@endcomponent

	</div>
</div>

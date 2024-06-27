<div class="row">
	<div class="col-lg-12">
		@component('components.block') @slot('title',
		trans('customer::language.addresses'))
		<div class="form-horizontal form-bordered">
			<div class="form-group">
				{!! Form::label('last_name', trans('customer::language.last_name'),
				['class' => 'col-md-3 control-label']) !!}
				<div class="col-md-6">{!! Form::text('last_name',
					$address->last_name, ['class' => 'form-control', 'required']) !!}</div>
			</div>

			<div class="form-group">
				{!! Form::label('first_name',
				trans('customer::language.first_name'), ['class' => 'col-md-3
				control-label']) !!}

				<div class="col-md-6">{!! Form::text('first_name',
					@$address->first_name, ['class' => 'form-control', 'required']) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('phone', trans('customer::language.phone'), ['class'
				=> 'col-md-3 control-label']) !!}

				<div class="col-md-6">{!! Form::text('phone', @$address->phone,
					['class' => 'form-control', 'required']) !!}</div>
			</div>

			<div class="form-group">
				{!! Form::label('address', trans('customer::language.address'),
				['class' => 'col-md-3 control-label']) !!}

				<div class="col-md-6">{!! Form::text('address', @$address->address,
					['class' => 'form-control', 'required']) !!}</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<div class="col-md-6">
							<div class="form_group" id="data_district" data-value="{{ $address->district ?: '' }}">
								<select name="district" class="form-control">
									<option value="N/A">Quận / District</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form_group" data-target="province" data-name="province" data-district="#data_district" data-value="{{ $address->province ?: 0 }}"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('default', trans('customer::language.default'),
				['class' => 'col-md-3 control-label']) !!}

				<div class="col-md-6">
					<label class="switch switch-warning"> <input type="checkbox"
						name="default" value="1" {{ $address->default ? 'checked' : '' }}>
						<span></span>
					</label>
				</div>
			</div>
		</div>
		@endcomponent

	</div>
</div>

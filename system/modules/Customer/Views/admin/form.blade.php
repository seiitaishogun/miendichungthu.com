@push('header')
	<style>
		.lockedButton .switch input + span {
			background-color: #f00;
			border-color: #f00;
		}

		.lockedButton .switch input:checked + span {
			background-color: #aad178;
			border-color: #aad178;
		}
	</style>
@endpush

<div class="row">
	<div class="col-lg-12">
		@component('components.block') @slot('title',
		trans('customer::language.customer_create'))
		<div class="form-horizontal form-bordered">
			<div class="form-group">
				{!! Form::label('last_name', trans('customer::language.last_name'),
				['class' => 'col-md-3 control-label']) !!}
				<div class="col-md-6">{!! Form::text('last_name',
					$customer->last_name, ['class' => 'form-control', 'required']) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('first_name',
				trans('customer::language.first_name'), ['class' => 'col-md-3
				control-label']) !!}

				<div class="col-md-6">{!! Form::text('first_name',
					@$customer->first_name, ['class' => 'form-control', 'required'])
					!!}</div>
			</div>

			<div class="form-group">
				{!! Form::label('email', trans('customer::language.email'), ['class'
				=> 'col-md-3 control-label']) !!}

				<div class="col-md-6">{!! Form::text('email', @$customer->email,
					['class' => 'form-control', 'required', 'data-rule-email' => true])
					!!}</div>
			</div>

			<div class="form-group">
				{!! Form::label('user_identifycation', trans('customer::language.user_identifycation'), ['class'
				=> 'col-md-3 control-label']) !!}

				<div class="col-md-6">{!! Form::text('user_identifycation', @$customer->user_identifycation,
					['class' => 'form-control'])
					!!}</div>
			</div>

			<div class="form-group">
				{!! Form::label('password', trans('customer::language.password'),
				['class' => 'col-md-3 control-label']) !!}

				<div class="col-md-6">
					{!! Form::password('password', ['class' => 'form-control']) !!}
					<p class="help-block">{{
						trans('customer::language.empty_not_change') }}</p>
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('password_confirmation',
				trans('customer::language.password_confirmation'), ['class' =>
				'col-md-3 control-label', 'id' => 'password']) !!}

				<div class="col-md-6">{!! Form::password('password_confirmation',
					['class' => 'form-control', 'data-rule-equalTo' => '#password'])
					!!}</div>
			</div>

			<div class="form-group">
				{!! Form::label('note', trans('customer::language.note'), ['class'
				=> 'col-md-3 control-label']) !!}

				<div class="col-md-6">{!! Form::textarea('note', $customer->note,
					['class' => 'form-control']) !!}</div>
			</div>

			<div class="form-group">
				{!! Form::label('tags', trans('customer::language.tags'), ['class'
				=> 'col-md-3 control-label']) !!}

				<div class="col-md-6">{!! Form::text('tags', $customer->tags,
					['class' => 'form-control input-tags']) !!}</div>
			</div>

			@if(allow('customer.group.index'))
			<div class="form-group">
				{!! Form::label('customer_group_id', 'Nhóm thành viên', ['class' =>
				'col-md-3 control-label']) !!}

				<div class="col-md-6">
					<select name="customer_group_id" id="customer_group_id"
						class="form-control">
						<option value="0">Không có nhóm</option>
						@foreach(\Modules\Customer\Models\Group::all() as $group)
						<option value="{{ $group->id }}" {{ $customer->customer_group_id
							== $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			@endif

			@if(allow('customer.source.index'))
			<div class="form-group">
				{!! Form::label('customer_source_id', 'Nguồn thành viên', ['class'
				=> 'col-md-3 control-label']) !!}

				<div class="col-md-6">
					<select name="customer_source_id" id="customer_source_id"
						class="form-control">
						<option value="0">Không có nguồn</option>
						@foreach(\Modules\Customer\Models\Source::all() as $source)
						<option value="{{ $source->id }}" {{ $customer->customer_source_id
							== $source->id ? 'selected' : '' }}>{{ $source->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			@endif

			<div class="form-group">
				{!! Form::label('recived_promo_mail',
				trans('customer::language.recived_promo_mail'), ['class' =>
				'col-md-3 control-label']) !!}

				<div class="col-md-6">
					<label class="switch switch-info"> <input type="checkbox"
						name="recived_promo_mail" value="1" {{ $customer->recived_promo_mail
						? 'checked' : '' }}> <span></span>
					</label>
				</div>
			</div>

			@if(config('cnv.cart_has_affiliate'))
			<div class="form-group">
				{!! Form::label('affiliate',
				trans('customer::language.affiliate'), ['class' =>
				'col-md-3 control-label']) !!}

				<div class="col-md-6">
					<label class="switch switch-info"> <input type="checkbox"
															name="affiliate" value="1" {{ $customer->affiliate
						? 'checked' : '' }}> <span></span>
					</label>
				</div>
			</div>
			@endif

			<div class="form-group">
				{!! Form::label('sex', trans('customer::language.sex'), ['class' =>
				'col-md-3 control-label']) !!}

				<div class="col-md-6">
					<div class="radio">
						<label for="male"> <input type="radio" id="male" name="sex"
							value="0"> {{ trans('customer::language.male') }}
						</label>
					</div>
					<div class="radio">
						<label for="female"> <input type="radio" id="female" name="sex"
							value="1"> {{ trans('customer::language.female') }}
						</label>
					</div>
				</div>
			</div>
			
			<div class="form-group lockedButton">
				{!! Form::label('user_confirm', 'User Confirm (Click link email?)',
				['class' => 'col-md-3 control-label']) !!}

				<div class="col-md-6">
					<input type="hidden" name="user_confirm" value="{{$customer->user_confirm}}">
					<label class="switch switch-success"> <input type="checkbox"
						name="user_confirm_" value="1" {{ $customer->user_confirm ? 'checked' :
						'' }}> <span></span>
					</label>
				</div>
			</div>

			<div class="form-group lockedButton">
				{!! Form::label('activated', 'Kích hoạt tài khoản (Khóa/Mở)',
				['class' => 'col-md-3 control-label']) !!}

				<div class="col-md-6">
					<input type="hidden" name="activated" value="0">
					<label class="switch switch-success"> <input type="checkbox"
						name="activated" value="1" {{ $customer->activated ? 'checked' :
						'' }}> <span></span>
					</label>
				</div>
			</div>

		</div>
		@endcomponent @include('custom_field::custom_fields', ['module' =>
		'customer', 'model' => $customer])
	</div>

</div>

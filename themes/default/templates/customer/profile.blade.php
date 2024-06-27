@extends('theme::layout')

@section('content')
    <section class="box customer-page">
        <div class="container">
            <section class="col-md-9 ptb-15">
                <div class="account-wrap cart-box">
                    <h4 class="text-center caption">{{ trans('custom.shop.profile') }}</h4>

                    @include('customer::web.message')

                    <form action="{{ url('/profile') }}" method="POST" class="gray-control">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            {!! Form::label('last_name', trans('customer::language.last_name'), ['class' => 'control-label']) !!}
                            {!! Form::text('last_name', old('last_name', $user->last_name), ['class' => 'form-control', 'required']) !!}
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            {!! Form::label('first_name', trans('customer::language.first_name'), ['class' => 'control-label']) !!}

                            {!! Form::text('first_name', old('first_name', $user->first_name), ['class' => 'form-control', 'required']) !!}
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('email', trans('customer::language.email'), ['class' => 'control-label']) !!}

                            {!! Form::text('email', old('email', $user->email), ['class' => 'form-control', 'required', 'disabled']) !!}
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            {!! Form::label('phone', trans('customer::language.phone'), ['class' => 'control-label']) !!}
                            {!! Form::text('phone', $address->phone, ['class' => 'form-control', 'required']) !!}
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form_group" data-target="province" data-name="province" data-district="#info_district" data-value="{{ $address->province }}"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form_group" id="info_district" data-value="{{ $address->district }}">
                                        <select name="district" class="form-control">
                                            <option value="N/A">Quận / District</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            {!! Form::label('address', trans('customer::language.address'), ['class' => 'control-label']) !!}
                            {!! Form::text('address', $address->address, ['class' => 'form-control', 'required']) !!}
                            @if ($errors->has('address'))
                                <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="checkbox" name="recived_promo_mail" id="recived_promo_mail" value="1" checked>
                            {!! Form::label('recived_promo_mail', trans('customer::language.recived_promo_mail'), ['class' => 'control-label']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('sex', trans('customer::language.sex'), ['class' => 'control-label']) !!}

                            <div class="radio">
                                <label for="male">
                                    <input type="radio" id="male" name="sex" value="0" required {{ !$user->sex ? 'checked' : '' }}> {{ trans('customer::language.male') }}
                                </label>
                            </div>
                            <div class="radio">
                                <label for="female">
                                    <input type="radio" id="female" name="sex" value="1" required {{ $user->sex ? 'checked' : '' }}> {{ trans('customer::language.female') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="theme-btn btn-black"> <b> {{ trans('language.save') }} </b> </button>
                        </div>
                    </form>
                </div>
            </section>

            @include('theme::customer.sidebar')
        </div>
    </section>
@stop

@extends('theme::layout')

@push('header')
<style>
    .control-label{
        font-weight: 700;
        padding-left: 5px;
    }

    .sidebar-item{
        padding: 15px;
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
    }

    .sidebar-item a{
        font-weight: 500;
    }

    h4.text-center.account-title {
        padding: 20px;
        background-color: black;
        color: white;
    }

        .form-control{
        border-color: black;
    }

    .form-custom-inline {
        display: flex;
    }

    .form-custom-inline > .form-group:first-child{
        padding-right: 5px;
        width: 50%;
    }

    .form-custom-inline > .form-group:last-child{
        padding-left: 5px;
        width: 50%;
    }

    .gray-control{
        padding: 10px;
        border: 1px solid black;
    }

    .theme-btn, .theme-btn-2, .theme-btn-3{
        border-radius: 0;
        height: 50px;
        line-height: 50px;
        width: 30%;
        background-color: black!important;
        color: white!important;
    }
</style>
@endpush

@section('content')
@include('theme::partial.heading')
    <section class="box">
        <div class="container">
            <div class="row">
                <section class="col-md-9 ptb-15">
                    <div class="account-wrap cart-box">
                        <h4 class="text-center account-title">{{ trans('custom.shop.profile') }}</h4>

                        @include('customer::web.message')

                        <form action="{{ url('/profile') }}" method="POST" class="gray-control">
                            {{ csrf_field() }}

                                <div class="form-custom-inline">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        {!! Form::label('last_name', trans('customer::language.last_name'). ' :', ['class' => 'control-label']) !!}
                                        {!! Form::text('last_name', old('last_name', $user->last_name), ['class' => 'form-control', 'required']) !!}
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        {!! Form::label('first_name', trans('customer::language.first_name'). ' :', ['class' => 'control-label']) !!}

                                        {!! Form::text('first_name', old('first_name', $user->first_name), ['class' => 'form-control', 'required']) !!}
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-custom-inline">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        {!! Form::label('phone', trans('customer::language.phone'). ' :', ['class' => 'control-label']) !!}
                                        {!! Form::text('phone', $address->phone, ['class' => 'form-control', 'required']) !!}
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        {!! Form::label('address', trans('customer::language.address'). ' :', ['class' => 'control-label']) !!}
                                        {!! Form::text('address', $address->address, ['class' => 'form-control', 'required']) !!}
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('email', trans('customer::language.email') . ' :', ['class' => 'control-label']) !!}

                                    {!! Form::text('email', old('email', $user->email), ['class' => 'form-control', 'required', 'disabled']) !!}
                                </div>

                                <input type="hidden" data-toggle="province" value="{{ $address->province }}">
                                <input type="hidden" data-toggle="district" value="{{ $address->district }}">
                                <input type="hidden" data-toggle="ward" value="{{ $address->ward }}">

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <div class="form_group">
                                                <select name="province" class="form-control non-select2" required="">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form_group">
                                                <select name="district" class="form-control non-select2" required="">
                                                    <option value="N/A">Quận / Huyện</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form_group">
                                                <select name="ward" class="form-control non-select2" required="">
                                                    <option value="N/A">Phường / Xã</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="recived_promo_mail" id="recived_promo_mail" value="1" checked>
                                    {!! Form::label('recived_promo_mail', trans('customer::language.recived_promo_mail'), ['class' => 'control-label']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('sex', trans('customer::language.sex'). ' :', ['class' => 'control-label','style' => 'margin-right:10px;']) !!}

                                    <div class="radio-inline">
                                        <label for="male">
                                            <input type="radio" id="male" name="sex" value="0" required {{ !$user->sex ? 'checked' : '' }}> {{ trans('customer::language.male') }}
                                        </label>
                                    </div>
                                    <div class="radio-inline">
                                        <label for="female">
                                            <input type="radio" id="female" name="sex" value="1" required {{ $user->sex ? 'checked' : '' }}> {{ trans('customer::language.female') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="theme-btn btn-black btn-background"> <b> {{ trans('language.save') }} </b> </button>
                                </div>
                        </form>
                    </div>
                </section>

                @include('customer::web.sidebar')
            </div>
        </div>
    </section>
@stop

@extends('theme::layout')

@push('header')
<link rel="stylesheet" href="{{ $theme_url }}/css/account.css">
<link rel="stylesheet" href="{{ $theme_url }}/css/general.css">
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

.form-custom-inline {
    display: flex;
}

.form-custom-inline > .form-group:first-child{
    padding-right: 5px;
    width: 50%;
}

.form-control{
    border-color: black;
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
    width: 40%;
    background-color: black!important;
    color: white!important;
}
</style>
@endpush

@section('content')
@include('theme::partial.heading')
    <section class="box">
        <div class="container">
            <div class="">
                <aside class="col-md-6 col-md-offset-3 ptb-15">
                    <div class="account-wrap cart-box">
                        <h4 class="text-center account-title">{{ trans('custom.shop.reset_password') }}</h4>

                        <form class="gray-control" role="form" method="POST" action="{{ route('customer.password.request') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">{{ trans('custom.shop.password') }}</label>
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">{{ trans('custom.shop.password_confirmation') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group text-center" >
                                <button type="submit" class="theme-btn btn-black btn-background">
                                    {{ trans('custom.shop.reset_password') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@stop
@push('header')
<style>
    .btn-background{
        border: medium none;
        border-radius: 2em;
        box-shadow: none;
        font-size: 18px;
        height: 52px;
        padding: 0 20px;
        color: #fff;
        line-height: 50px;
    }
</style>
@endpush

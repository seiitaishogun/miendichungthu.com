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
            <div class="">
                <aside class="col-md-6 col-md-offset-3 ptb-15">
                    <div class="account-wrap cart-box">
                        <h4 class="text-center account-title">{{ trans('custom.shop.login') }}</h4>

                        <form action="{{ url('/login') }}" method="POST"     class="gray-control">
                            <input type="hidden" name="redirect" value="{{ request()->get('redirect') ?: '/' }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label">{{ trans('custom.shop.email') }}</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required="">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label">{{ trans('custom.shop.password') }}</label>
                                <input type="password" name="password" class="form-control" required="">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <a href="/register">{{ trans('custom.shop.register') }}</a> &bull; <a href="{{ route('customer.password.request') }}">{{ trans('custom.shop.forgot_password') }}</a>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="theme-btn btn-black btn-background"> <b> {{ trans('custom.shop.login') }} </b> </button>
                            </div>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@stop

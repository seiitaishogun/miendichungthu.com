@php
if ( (isset($_COOKIE['user']) && !empty($_COOKIE['user'])) ) {
    echo "<script>window.location.href='/';</script>";
}
@endphp
@extends('theme::layout')
@push('header')
     <link href="{{ $theme_url }}/assets/css/auth.css" type="text/css" rel="stylesheet" />
@endpush
@section('content')
    @include('theme::partial.heading')
    <section class="box login-res-page">
        <div class="container">
            <div class="col-md-8 offset-md-2 ptb-15">
                <div class="account-wrap cart-box">

                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
                                <h4 class="text-left welcome-text"><strong>{{ session('lang') == 'vi' ? 'Chào mừng đến với' : 'Wellcome to ' }} {{ get_option('site_business_license') }}. {{ session('lang') == 'vi' ? 'Đăng nhập ngay' : 'Register' }}</strong></h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 register-link register-link-custom">
                            <p class="title_register_new">{{ trans('custom.customer.new_member') }}? <a href="/register?screenToRender=traditionalRegistration">{{ trans('custom.customer.register') }}</a> {{ trans('custom.customer.at_here') }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div id="DigitalIdentityHubHost"></div>
                    </div>

                    <!-- <form action="{{ url('/login') }}" method="POST" class="gray-control form_login_cus">
                        <input type="hidden" name="redirect" value="{{  request()->get('redirect') ?: '/' }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} form-group-login">
                                <label>{{ trans('custom.customer.email_address') }} *</label>
                                <input type="email" placeholder="{{ trans('custom.customer.enter_your_email') }}" name="email" value="{{ old('email') }}" class="form-control" required="">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} form-group-login">
                                <label>{{ trans('custom.customer.password') }} *</label>
                                <input type="password" name="password" placeholder="{{ trans('custom.customer.enter_your_password') }}" class="form-control" required="">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group action action-login">

                                     <a class="pull-right btn-link forgot_password" href="{{ route('customer.password.request') }}">{{ trans('custom.customer.forgot_password') }} ?</a>

                                    <button type="submit" class="btn-login btn-login">{{ trans('custom.customer.login') }}</button> -->

                                <!-- <div class="col-sm-6 col-xs-12">
                                    <p>{{ trans('custom.customer.contact_with_social') }}</p>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <a href="/login/facebook"><button type="button" class="btn-facebook"> <b><i class="fa fa-facebook" aria-hidden="true"></i> Facebook </b> </button></a>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <a href="/login/google"><button type="button" class="btn-google"> <b><i class="fa fa-google-plus" aria-hidden="true"></i> Google </b> </button></a>
                                        </div>
                                    </div>
                                </div> -->
                            <!-- </div>
                        </div>
                    </form> -->
                </div>
            </div>
        </div>
    </section>

    <style>
        .form_login_cus{
            margin-top: 10px;
        }
    </style>
    <link href="{{ $theme_url }}/assets/css/fep-customization.css" type="text/css" rel="stylesheet" />

    <script src="{{ $theme_url }}/assets/js/fep-customization.js"></script>


@stop

@extends('theme::layout')

@section('content')
    <section class="box customer-page">
        <div class="container">
            <section class="col-md-9 ptb-15">
                <div class="account-wrap cart-box">
                    <h4 class="text-center caption">{{ trans('custom.shop.change_password') }}</h4>

                    @include('customer::web.message')

                    <form action="{{ url('/profile/password') }}" method="POST" class="gray-control">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label>{{ trans('custom.shop.old_password') }}</label>
                            <input type="password" name="old_password" class="form-control" required="">
                            @if ($errors->has('old_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label>{{ trans('custom.shop.password') }}</label>
                            <input type="password" name="password" class="form-control" required="">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label>{{ trans('custom.shop.password_confirmation') }}</label>
                            <input type="password" name="password_confirmation" class="form-control" required="">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
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

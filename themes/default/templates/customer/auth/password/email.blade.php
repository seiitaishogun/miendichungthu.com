@extends('theme::layout')

@section('content')
    <section class="box">
        <div class="container">

            {{-- Header Banner --}}
            @include('theme::partial.heading')
            {{-- Header Banner --}}

            <div class="row">
                <aside class="col-12 col-sm-12 col-md-12 col-lg-9 offset-lg-2 col-xl-9 offset-xl-2 ptb-15">
                    <div class="account-wrap cart-box">
                        <h4 class="text-center title-reset-password">{{ trans('custom.shop.reset_password') }}</h4>

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('customer.password.request') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">{{ trans('custom.shop.password') }}</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">{{ trans('custom.shop.password_confirmation') }}</label>
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn-black btn-theme btn-reset-pass">
                                        {{ trans('custom.shop.reset_password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>
    @push('footer')
    <style>
        .popup_checking{
            display: none !important;
        }
    </style>
    @endpush
@stop

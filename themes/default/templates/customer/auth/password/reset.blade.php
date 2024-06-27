@extends('theme::layout')


@section('content')
    @include('theme::partial.heading')
    <section class="box login-res-page">
        <div class="container">
            {{-- Header Banner --}}
           
            {{-- Header Banner --}}
            <div class="row">
                <aside class="col-12 col-sm-12 col-md-12 col-lg-12  ptb-15">
                    <div class="account-wrap cart-box">
                        <h4 class="text-center text-reset">{{ trans('custom.shop.reset_password') }}</h4>

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('customer.password.email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">


                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                        <label for="email" class="control-label">Địa chỉ Email</label>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-10 col-lg-10">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    </div>

                                    @if ($errors->has('email'))
                                        <div class="help-block help-block-reset col-12 col-sm-12 col-md-10 offset-md-2 col-lg-10 offset-lg-2">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="theme-btn btn-black btn-reset-pass">
                                        <b> {{ session('lang') == 'vi' ? 'Khôi phục mật khẩu' : 'Reset Password' }} </b>
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
        .text-reset {
            font-weight: bold;
            font-size: 18px;
        }
        .theme-btn, .theme-btn-2, .theme-btn-3 {
            border: medium none;
            box-shadow: none;
            font-size: 15px;
            height: auto;
            width: 300px;
            padding: 0 50px;
            color: #fff;
        }
        .popup_checking{
            display: none !important;
        }
    </style>
    @endpush
@stop

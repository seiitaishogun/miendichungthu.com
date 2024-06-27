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

        .form-control{
        border-color: black;
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
                <section class="col-md-9 ptb-15">
                    <div class="account-wrap cart-box">
                        <h4 class="text-center account-title">{{ trans('custom.shop.change_password') }}</h4>

                        @include('customer::web.message')

                        <form action="{{ url('/profile/password') }}" method="POST" class="gray-control">
                            {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                    <label class="control-label">{{ trans('custom.shop.old_password') }} :</label>
                                    <input type="password" name="old_password" class="form-control" required="">
                                    @if ($errors->has('old_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label">{{ trans('custom.shop.password') }} :</label>
                                    <input type="password" name="password" class="form-control" required="">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label class="control-label">{{ trans('custom.shop.password_confirmation') }} :</label>
                                    <input type="password" name="password_confirmation" class="form-control" required="">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
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

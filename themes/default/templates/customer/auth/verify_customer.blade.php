@extends('theme::layout')
@push('header')
     <link href="{{ $theme_url }}/assets/css/auth.css" type="text/css" rel="stylesheet" />
@endpush
@section('content')
    <section class="box login-res-page">
        <div class="container">
            {{-- Header Banner --}}
            @include('theme::partial.heading')
            {{-- Header Banner --}}
                    <div class="row">
                        <div class="block_verify col-12 col-sm-12 col-md-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 text-center">
                               <span class="label label-default"><b>{{ $notification_status }}</b></span>
                               <br/>
                               <span class="label label-default">
                                   {{ session('lang') == 'vi' ? 'Bấm vào link sau để đăng nhập' : 'Click on the following link to login' }} <a class="link_login_verify" href="{{ url('login') }}" >Link</a>
                               </span>
                        </div>
                    </div>

        </div>
    </section>

@stop

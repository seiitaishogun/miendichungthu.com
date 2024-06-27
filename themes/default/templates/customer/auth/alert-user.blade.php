@extends('theme::layout')
@push('header')
     <link href="{{ $theme_url }}/assets/css/auth.css" type="text/css" rel="stylesheet" />
@endpush
@section('content')
    @include('theme::partial.heading')
    <section id="login_wrap" class="box login-res-page">
        <div class="container">
            <div class="col-md-8 offset-md-2 ptb-15">
                <div class="account-wrap cart-box">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="row">
                                <h4 class="text-left welcome-text"><strong>{{ session('lang') == 'vi' ? 'Chào mừng đến với' : 'Wellcome to ' }} {{ get_option('site_business_license') }}.</strong></h4>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 register-link register-link-custom">
                            <p class="title_register_new">{{ trans('custom.customer.new_member') }}? <a href="/register">{{ trans('custom.customer.register') }}</a> {{ trans('custom.customer.at_here') }}</p>
                        </div>
                    </div>
                    <div class="row">
                    @php $type_ = session( 'alert_user' ); @endphp
                    @if($type_ == 'none_verify')
                        <h4 class="alert-user">
                            <i class="fa fa-exclamation-circle"></i> Tài khoản của Quý Cán Bộ Y Tế đang chờ xét duyệt hoặc chưa xác nhận địa chỉ email. Vui lòng quay lại sau.
                        </h4>
                    @elseif($type_ == 'reser_email')
                        <h4 class="alert-user">
                            <i class="fa fa-exclamation-circle"></i> Vui lòng kiểm tra email của bạn để thực hiện các thao tác tiếp theo để thay đổi password.
                        </h4>
                    @elseif($type_ == 'verify')
                        <h4 class="alert-user">
                            <i class="fa fa-exclamation-circle"></i> Tài khoản email của Quý Cán Bộ Y Tế đã được xác nhận. Quý Cán Bộ Y Tế sẽ nhận được email thông báo từ hệ thống về việc truy cập website.
                        </h4>
                    @elseif($type_ == 'success')
                        <h4 class="alert-user">
                            <i class="fa fa-exclamation-circle"></i> Tài khoản của Quý Cán Bộ Y Tế đã được đăng ký. Vui lòng truy cập email để xác nhận thông tin đăng ký của quý vị.
                        </h4>
                    @else

                    @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .form_login_cus{
            margin-top: 10px;
        }
        .popup_checking{
            display: none !important;
        }
    </style>

@stop
@push('footer')
    <script type="text/javascript">
    $(document).ready(function(){
        $(window).load(function(){
        setTimeout(function() {
            $('body, html').animate({
                scrollTop: $('#login_wrap').offset().top - 60
            }, 700);
        }, 1000);
        });
    });
    </script>
@endpush

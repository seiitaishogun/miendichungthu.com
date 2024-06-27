@php
if ( (isset($_COOKIE['user']) && !empty($_COOKIE['user'])) ) {
    echo "<script>window.location.href='/';</script>";
}
@endphp
@extends('theme::layout')
@push('header')
     <link href="{{ $theme_url }}/assets/css/auth.css" type="text/css" rel="stylesheet" />
     <style>
         .banner{
            margin-bottom: 0px;
         }
     </style>
@endpush
@section('content')
    @php
        preg_match('/<img src\=\"(.*?)\"/is',widget('banner-trang-dang-ky'),$images);
    @endphp
    <div class="banner">
        <img src="{{ $images[1]  }}" alt="" title="" />
        {{-- <div class="breadcrumbs">
            <div class="container">
                <ul>
                    <li><a href="{{ url('/') }}">{{ trans('language.home') }}</a></li>
                      @foreach($breadcrumb as $item)
                        <li><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                      @endforeach
                </ul>
            </div>
        </div> --}}
    </div>

    <div class="container-fluid container-form">
        <div class="row">
            <dib class="col-lg-12 container_label">
                <span class='title_dk'>Đăng ký</span>
                <br/>
                <h3 class="title_tk">Tạo tài khoản</h3>
            </dib>
        </div>

        
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div id="DigitalIdentityHubHost"></div>
                </div>
            </div>
        </div>

        <!-- <div class="filter applyform">
            <form  class="form-horizontal form-validate" method="post" action="{{ url('/register') }}"  novalidate="novalidate" data-callback="reload_page">
                <div class="container wow fadeInUp form-wrapper">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="line">
                                <span>Danh xưng</span>
                                <div class="fix-position form-group">
                                    <select name="prefix" class="non-select2">
                                        @foreach(getAllPrefix() as $prefix)
                                            <option value="{{ $prefix }}">{{ $prefix }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="line">
                                <span>Họ và tên lót</span>  <span style="color:red">*</span>
                                <div class="fix-input form-group">
                                    <input placeholder="Ví dụ : Nguyễn Văn" required autocomplete="off" id="first_name" class="form-control" name="first_name">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="line">
                                <span>Tên</span>  <span style="color:red">*</span>
                                <div class="fix-input form-group non-select2">
                                    <input placeholder="Ví dụ : An" required autocomplete="off" id="last_name" type="text" class="form-control" name="last_name">
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>


                        <div class="col-md-6 col-sm-6">
                            <div class="line">
                                <span>Bệnh viện</span>  <span style="color:red">*</span>
                                <div class="fix-input form-group">
                                    <input  required autocomplete="off"  type="text" class="form-control" name="hospital">
                                     {{-- <select name="hospital" class="non-select2 select_option">
                                        <option value="">Vui lòng chọn</option>
                                       @foreach(config('cnv.hospitals') as $key => $hospital)
                                            <option value="{{ $key }}">{{ $hospital }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="line">
                                <span>Tỉnh / Thành Phố</span>  <span style="color:red">*</span>
                                <div class="fix-input form-group non-select2">
                                     <select name="province" class="non-select2 select_option">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>


                        <div class="col-md-4 col-sm-4">
                            <div class="line">
                                <span>Nghề Nghiệp</span>  <span style="color:red">*</span>
                                <div class="fix-input form-group">
                                     <select name="job" class="non-select2 select_option">
                                        <option value="">Vui lòng chọn</option>
                                        @foreach(config('cnv.jobs') as $key => $job)
                                            <option value="{{ $key }}">{{ $job }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4">
                            <div class="line">
                                <span>Chuyên khoa</span>  <span style="color:red">*</span>
                                <div class="fix-input form-group">
                                     <select name="specialists" class="non-select2 select_option">
                                        <option value="">Vui lòng chọn</option>
                                        @foreach(config('cnv.specialists') as $key => $specialist)
                                            <option value="{{ $key }}">{{ $specialist }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4">
                            <div class="line">
                                <span>Số năm kinh nghiệm</span> <span style="color:red">*</span>
                                <div class="fix-input form-group non-select2">
                                     <input required  autocomplete="off" id="experience" type="number" class="form-control" name="experience">
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>



                        <div class="col-md-6 col-sm-6">
                            <div class="line">
                                <span>Email</span>  <span style="color:red">*</span>
                                <div class="fix-email form-group">
                                    <input required autocomplete="off" id="email" type="email" class="form-control" name="email">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="line">
                                <span>Điện thoại</span>  <span style="color:red">*</span>
                                <div class="fix-contact form-group">
                                    <input required autocomplete="off" type="text" id="contact" name="phone" class="form-control input-medium bfh-phone" data-country="VN">
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6 col-sm-6">
                            <div class="line">
                                <span>Mật khẩu</span>  <span style="color:red">*</span>
                                <div class="fix-email form-group">
                                    <input class="form-control" name="password" type="password" value="" id="password" required="" >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="line">
                                <span>Xác nhận mật khẩu</span>  <span style="color:red">*</span>
                                <div class="fix-contact form-group">
                                    <input class="form-control" data-rule-equalto="#password" name="password_confirmation" type="password" value="" id="password_confirmation" required="">
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="form-group recived-promo-mail col-md-12 col-sm-12">
                                {{-- <input onclick="return false;" required type="checkbox" name="recived_promo_mail" id="recived_promo_mail" value="1" checked> --}}
                                <h2>Lựa chọn liên lạc</h2>
                                <label for="recived_promo_mail" class="control-label recived_promo_mail">
                                    <input   type="checkbox" name="recived_promo_mail" id="recived_promo_mail" value="1" >
                                        {!! widget('dang-ky-vui-long-nhanj-lien-lac') !!}
                                </label>
                        </div>

                        <div class="clearfix"></div>

                        <div class="form-group recived-promo-mail col-md-12 col-sm-12">
                                <h2>Điều khoản sử dụng và riêng tư</h2>
                                <label for="terms_of_use" class="control-label recived_promo_mail terms_of_use">
                                    <input  type="checkbox" name="terms_of_use" id="terms_of_use" value="1" >
                                    {!!strip_tags( widget('dang-ky-toi-dong-y-dieu-khoan-su-dung'),'<a>') !!}  <span style="color:red">*</span>
                                </label>
                                <br/>
                                <label for="privacy_policy" class="control-label recived_promo_mail terms_of_use">
                                    <input  type="checkbox" name="privacy_policy" id="privacy_policy" value="1" >
                                    {!! strip_tags(widget('dang-ky-toi-dong-y-chinh-sach-bao-mat'),'<a>') !!}  <span style="color:red">*</span>
                                </label>
                        </div>


                        </div>




                         <div class="form-group col-md-12 col-sm-12 thankyou remove_padding">
                               <div class="button">
                                   <button type="submit" class="btn submit submit_register">Đăng ký tài khoản</button>
                               </div>
                        </div>


                    </div>
                </div>

            </form>

        </div> -->
    </div>
    <link href="{{ $theme_url }}/assets/css/fep-customization.css" type="text/css" rel="stylesheet" />
    <script src="{{ $theme_url }}/assets/js/fep-customization.js"></script>
@stop


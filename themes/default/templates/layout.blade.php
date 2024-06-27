<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"> <!--<![endif]-->
<head>
    <script>
        window.dataLayer = window.dataLayer || []; // Google Tag Manager
    </script>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ (isset($title) ? $title .' - ' : '') . config('app.name') }}</title>
    <meta name="description" content="{{ isset($description) ? $description : get_option('site_description') }}">

    @include('partial.cms_head_fe')

    <!-- Stylesheets -->
    <link href="{{ $theme_url }}/assets/css/slick.css" type="text/css" rel="stylesheet">
    <link href="{{ $theme_url }}/assets/css/animate.css" type="text/css" rel="stylesheet">
    <link href="{{ $theme_url }}/assets/fonts/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <!-- <link href="fonts/elegantIcon/elegantIcon.css" type="text/css" rel="stylesheet"> -->

    <link href="{{ $theme_url }}/assets/css/main.css?v=20210204" type="text/css" rel="stylesheet">
    <link href="{{ $theme_url }}/assets/css/custom.css?v=20210219" type="text/css" rel="stylesheet">
    <link href="{{ $theme_url }}/assets/css/cnv.css" type="text/css" rel="stylesheet">
    <style>
        .popup_checking{
            display: none;
        }
    </style>
    <!-- END Stylesheets -->
    @stack('header')
    {!! get_option('facebook_pixel') !!}

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push(
    {'gtm.start': new Date().getTime(),event:'gtm.js'}
    );var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N5TVPMQ');</script>
    <!-- End Google Tag Manager -->

    <!-- Frontend package -->
    <!-- <link rel="stylesheet" type="text/css" href="https://dmc-front-end-package-dev.mrk-mdlwr.com/latest/vn/css/basic-dih-library-styles.css"> -->
    <link rel="stylesheet" type="text/css" href="https://dmc-front-end-package.mrk-mdlwr.com/v2.5.x/vn/css/basic-dih-library-styles.css">
    <link rel="stylesheet" type="text/css" href="https://d21x7jv2u06zw.cloudfront.net/il/mcconsent/style.39bef083c50f51d503f3.css">
</head>
<body>
<script>
    data = [
                ['Trang chủ', 'homepage', 'other'],
                ['Đăng nhập', 'login', 'other'],
                ['Keytruda | Thông tin chung', 'product', 'prescribing information'],
                ['Keytruda | Chỉ định - Chống chỉ định', 'product', 'indication'],
                ['Keytruda | Liều lượng - Cách dùng', 'product', 'dosing'],
                ['Keytruda | Cảnh báo - Thận trọng', 'product', 'prescribing information'],
                ['Keytruda | Phản ứng bất lợi', 'product', 'prescribing information'],
                ['Keytruda | Dược lý lâm sàng', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - U bào ác tính Melanoma', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - Ung thư phổi không tế bào nhỏ', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - U lympho Hodgkin kinh điển', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - Ung thư biểu mô đường tiết niệu', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - Ung thư đầu và cổ', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - Ung thư dạ dày', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - Ung thư biểu mô tế bào gan', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - Ung thư cổ tử cung', 'product', 'indication'],
                ['Keytruda | Dược lý lâm sàng - Ung thư tình trạng mất ổn định vệ tinh mức độ cao', 'product', 'indication'],
                ['Keytruda | Dược động học', 'product', 'prescribing information'],
                ['Điều khoản riêng tư', 'other', 'privacy'],
                ['Điều khoản sử dụng', 'other', 'terms and conditions'],
                ['Sơ đồ trang', 'other', 'site navigation']
            ]

    switch ('{{Request::path()}}') {
        case '/': data_use = data[0]; break;
        case 'login': data_use = data[1]; break;
        case 'pages/thong-tin-chung': data_use = data[2]; break;
        case 'pages/chi-dinh-chong-chi-dinh': data_use = data[3]; break;
        case 'pages/lieu-luong-cach-dung': data_use = data[4]; break;
        case 'pages/canh-bao-than-trong': data_use = data[5]; break;
        case 'pages/phan-ung-bat-loi': data_use = data[6]; break;
        case 'blogs/duoc-ly-lam-sang/duoc-ly-lam-sang': data_use = data[7]; break;
        case 'blogs/duoc-ly-lam-sang/u-hac-bao-ac-tinh-melanoma': data_use = data[8]; break;
        case 'blogs/duoc-ly-lam-sang/ung-thu-phoi-khong-te-bao-nho': data_use = data[9]; break;
        case 'blogs/duoc-ly-lam-sang/u-lympho-hodgkin-kinh-dien-chl': data_use = data[10]; break;
        case 'blogs/duoc-ly-lam-sang/ung-thu-bieu-mo-duong-tiet-nieu': data_use = data[11]; break;
        case 'blogs/duoc-ly-lam-sang/ung-thu-dau-va-co': data_use = data[12]; break;
        case 'blogs/duoc-ly-lam-sang/ung-thu-da-day': data_use = data[13]; break;
        case 'blogs/duoc-ly-lam-sang/ung-thu-bieu-mo-te-bao-gan': data_use = data[14]; break;
        case 'blogs/duoc-ly-lam-sang/ung-thu-co-tu-cung': data_use = data[15]; break;
        case 'blogs/duoc-ly-lam-sang/ung-thu-co-tinh-trang-mat-on-dinh-vi-ve-tinh-muc-do-cao-msi-h': data_use = data[16]; break;
        case 'pages/duoc-dong-hoc': data_use = data[17]; break;
        case 'pages/dieu-khoan-rieng-tu': data_use = data[18]; break;
        case 'pages/dieu-khoan-su-dung': data_use = data[19]; break;
        case 'pages/so-do-trang': data_use = data[20]; break;
    }

    dataLayer.push({
        "page": {
            "page_title": data_use[0],
            "page_type": data_use[1],
            "page_purpose": data_use[2],
            "page_therapeuticarea": "oncology",
            "page_pathology": "general",
            "page_localproductname": "keytruda"
        }
    });
</script>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N5TVPMQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@include('theme::partial.header')

@yield('content')

@include('theme::partial.footer')

{{--<script>--}}
{{--(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){--}}
{{--(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),--}}
{{--m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)--}}
{{--})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');--}}
{{--ga('create', 'UA-156341568-3', 'auto');--}}
{{--@if(Auth::guard('customer')->check())--}}
{{--  var dimensionValue = '';--}}
{{--  dimensionValue = '{{Auth::guard('customer')->user()->user_identifycation}}';--}}
{{--  if(dimensionValue){--}}
{{--    ga('set', 'userId', dimensionValue);--}}
{{--    ga('set', 'dimension1', 'User');--}}
{{--    ga('set', 'dimension2', dimensionValue);--}}
{{--    ga('set', 'dimension3', dimensionValue);--}}
{{--  }--}}
{{--@else--}}
{{--  ga('set', 'dimension1', 'Visitor');--}}
{{--@endif--}}
{{--ga('send', 'pageview');--}}
{{--</script>--}}
{!! get_option('google_remaketing') !!}
{!! get_option('livechat') !!}

@include('partial.cms_footer_fe')



<script src="{{ $theme_url }}/assets/js/wow.min.js"></script>
<script src="{{ $theme_url }}/assets/js/slick.min.js"></script>
<script src="{{ $theme_url }}/assets/js/script.js"></script>
<script src="{{ $theme_url }}/assets/js/cnv.js"></script>
<!-- <script src="https://dmc-front-end-package-dev.mrk-mdlwr.com/latest/vn/dih-library.js"></script> -->
<script src="https://dmc-front-end-package.mrk-mdlwr.com/v2.5.x/vn/dih-library.js"></script>
@stack('footer')

</body>
</html>

DK gửi topup:
1/  Lead: Med
  Phải follow ZA
  Chưa có purchase tran (Zalo user -> Loyalty) && Chưa có purchase order
  Chưa có topup

2/  User đến từ ZNS
  Thuộc 1 trong 2 template (CRM Call hoặc chạy campaign tay)
  Chưa có purchase tran (Zalo user -> Loyalty) && Chưa có purchase order
  Chưa có topup
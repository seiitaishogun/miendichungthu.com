<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en"> <!--<![endif]-->
<head>
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

    <link href="{{ $theme_url }}/assets/css/main.css" type="text/css" rel="stylesheet">
    <link href="{{ $theme_url }}/assets/css/custom.css" type="text/css" rel="stylesheet">
    <link href="{{ $theme_url }}/assets/css/cnv.css" type="text/css" rel="stylesheet">
    <style>
        .popup_checking{
            display: none;
        }
    </style>
    <!-- END Stylesheets -->
    @stack('header')
    {!! get_option('facebook_pixel') !!}
</head>
<body>

@include('theme::partial.header_new')

@yield('content')

@include('theme::partial.footer')

{!! get_option('google_analytics') !!}
{!! get_option('google_remaketing') !!}
{!! get_option('livechat') !!}

@include('partial.cms_footer_fe')



<script src="{{ $theme_url }}/assets/js/wow.min.js"></script>
<script src="{{ $theme_url }}/assets/js/slick.min.js"></script>
<script src="{{ $theme_url }}/assets/js/script.js"></script>
<script src="{{ $theme_url }}/assets/js/cnv.js"></script>

@stack('footer')

</body>
</html>

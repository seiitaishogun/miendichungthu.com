<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ (isset($title) ? $title .' - ' : '') . config('app.name') }}</title>

@include('partial.cms_head')
<!-- Stylesheets -->
    <link rel="stylesheet" href="/backend/css/main.css">
    <link rel="stylesheet" href="/backend/css/themes.css">
    <!-- END Stylesheets -->

    <!-- Modernizr (browser feature detection library) -->
    <script src="/backend/js/vendor/modernizr.min.js"></script>
    @stack('header')
</head>
<body>

@yield('layout')

<!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
@include('partial.cms_footer')
<script src="/backend/js/app.js"></script>
@stack('footer')

</body>
</html>
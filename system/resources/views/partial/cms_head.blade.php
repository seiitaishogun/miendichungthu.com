<base href="{{asset('')}}">
<link rel="stylesheet" href="/backend/css/bootstrap.min.css">
<link rel="stylesheet" href="/backend/css/plugins.css">
<link rel="stylesheet" href="/assets/vendor/toastr/toastr.min.css">
<link rel="stylesheet" href="/assets/vendor/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="/assets/vendor/flag/css/flag-icon.min.css">
@if(request()->segment(1) === 'iadmin')
    <link rel="apple-touch-icon" sizes="57x57" href="https://cnv.vn/cnv-resources/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://cnv.vn/cnv-resources/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://cnv.vn/cnv-resources/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://cnv.vn/cnv-resources/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://cnv.vn/cnv-resources/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://cnv.vn/cnv-resources/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://cnv.vn/cnv-resources/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://cnv.vn/cnv-resources/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://cnv.vn/cnv-resources/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="https://cnv.vn/cnv-resources/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://cnv.vn/cnv-resources/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="https://cnv.vn/cnv-resources/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://cnv.vn/cnv-resources/favicon/favicon-16x16.png">
    <link rel="manifest" href="https://cnv.vn/cnv-resources/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="https://cnv.vn/cnv-resources/favicon/ms-icon-144x144.png'">
    <meta name="theme-color" content="#008dd0">
@else
    <link rel="icon" href="{{ option('site_favicon') }}">
@endif

<script>
    window.CNV = {!! json_encode([
            'baseUrl'  => url('/'),
            'csrfToken' => csrf_token(),
            'isLogin' => Auth::check()
        ]) !!};
</script>
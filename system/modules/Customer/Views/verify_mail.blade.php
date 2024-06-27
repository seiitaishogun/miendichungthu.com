<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <h3>{{ trans('custom.from') }} <a href="{{ get_option('site_name') }}">{{ get_option('site_name') }}</a></h3>


        <p>
                {{ trans('custom.notification_dear') . $customer->getFullNameAttribute() }},<br>
                {{ trans('custom.notification_welcome') . get_option('site_name') }} <br>
                {{ trans('custom.notification_verify') }} <a href="{{ $customer->getVerifyLink() }}">{{ $customer->getVerifyLink() }}</a> <br>
            Copyright © 2020 {{ get_option('site_name') }}. All Rights Reserved.
        </p>

    <p>

    </p>
</body>
</html>

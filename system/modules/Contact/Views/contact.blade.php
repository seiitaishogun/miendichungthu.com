<!DOCTYPE html>
<html>
<head>
</head>
<body>
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td class="content-cell">
                                    <p>{{ trans('contact::web.contact_from') }} {{ get_option('site_name') }}</p>
                                    <hr />
                                    <p>{{ trans('contact::web.your_subject') }}: {{ $title }}</p>
                                    <p>{{ trans('contact::web.your_name') }}: {{ $name }}</p>
                                    <p>Email: {{ $email }}</p>
                                    <p>{{ trans('contact::web.your_phone') }}: {{ $phone }}</p>
                                    <p>{{ trans('contact::web.your_message') }}:</p>
                                    <p>{!! $content !!}</p>
                                    <p></p>
                                    <p>{{ get_option('site_name') }}</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td class="content-cell" align="center">© {{ date('Y') }} <span>{{ get_option('site_name') }}</span>. All rights reserved.</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
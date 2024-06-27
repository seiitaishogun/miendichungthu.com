<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<table class="wrapper" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center">
<table class="content" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="header">
<h1 style="text-align: center;">Miễn Dịch Ung Thư</h1>
</td>
</tr>
<tr>
<td class="body" cellpadding="0" cellspacing="0" width="100%">
<table class="inner-body" width="570" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td class="content-cell"><span style="font-family: arial, helvetica, sans-serif;">@if ($level == 'error')</span>
<h1 id="mcetoc_1bbps393g1"><span style="font-family: arial, helvetica, sans-serif;">Whoops!</span></h1>
<span style="font-family: arial, helvetica, sans-serif;">@else</span>
<h1 id="mcetoc_1bbps393g2"><span style="font-family: arial, helvetica, sans-serif;">Chào mừng quý Cán Bộ Y Tế !</span></h1>
<p><span style="font-family: arial, helvetica, sans-serif;">Chúng tôi đã nhận được thông tin thay đổi mật khẩu của Quý cán bộ Y Tế trên trang Miễn dịch ung thư</span></p>
<p><span style="font-family: arial, helvetica, sans-serif;">Để hoàn tất việc thay đổi, quý vị vui lòng nhấp vào đường link bên dưới để xác nhận:</span></p>
<p><span style="font-family: arial, helvetica, sans-serif;">@endif</span></p>
<p><span style="font-family: arial, helvetica, sans-serif;">@foreach ($introLines as $line) {{ $line }} @endforeach @if (isset($actionText)) @php switch ($level) { case 'success': $color = 'green'; break; case 'error': $color = 'red'; break; default: $color = 'blue'; } @endphp</span></p>
<table class="action" width="100%" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td align="center">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td align="center">
<table cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td><span style="font-family: arial, helvetica, sans-serif;"><a href="/iadmin/option/email/system/{{ $actionUrl }}" class="button button-{{ $color or 'blue' }}" target="_blank" rel="noopener noreferrer">{{ $actionText }}</a></span></td>
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
<p><span style="font-family: arial, helvetica, sans-serif;">@endif @foreach ($outroLines as $line) {{ $line }} @endforeach</span></p>
<p></p>
<p><span style="font-family: arial, helvetica, sans-serif;">Sau khi xác nhận việc thay đổi mật khẩu, Quý Cán bộ Y Tế có thể truy cập vào website với mật khẩu mật mới.</span></p>
<p style="font-size: 14px; color: #000; padding: 0; margin: 20px 0 30px 0; line-height: 24px;"><span style="font-family: arial, helvetica, sans-serif;"><i>Đây là email tự động từ hệ thống, xin vui lòng không liên lạc qua email này.</i> </span><br /><span style="font-family: arial, helvetica, sans-serif;"> Trân trọng, </span><br /><span style="font-family: arial, helvetica, sans-serif;"> Ban quản trị trang Miễn dịch ung thư</span></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td>
<table class="footer" width="570" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td class="content-cell" align="center"><span style="font-family: arial, helvetica, sans-serif;">Copyright © 2020 {{ get_option('site_name') }}. All Rights Reserved.</span></td>
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
<p></p>
</body>
</html>
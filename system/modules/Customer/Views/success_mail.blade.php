<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div style="min-width:100%;width:100%!important;min-width:300px;max-width:100%;margin:0 auto;min-height:100%;padding:0px;background-color:#e8e8e8;">
    <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 650px;">
        <tbody>
            <tr>
                <td style=" background-color: rgb(246, 247, 248); ">
                    <h1 style="text-align: center;">Miễn Dịch Ung Thư</h1>
                </td>
            </tr>
            <tr>
				<td valign="top" width="650" style="background: #fff;">
				<!--[if gte mso 9]>
					<v:image xmlns:v="urn:schemas-microsoft-com:vml" id="theImage" style='behavior: url(#default#VML); display:inline-block; position:absolute; height:715px; width:650px; top:0; left:0; border:0; z-index:1;' src="2.jpg"/>
					<v:shape xmlns:v="urn:schemas-microsoft-com:vml" id="theText" style='behavior: url(#default#VML); display:inline-block; position:absolute; height:715px; width:650px; top:-5; left:0; border:0; z-index:2;'>
				<![endif]-->
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
						<tbody>
						<tr>
							<td>
                                <p style="font-family:arial,sans-serif; font-size:14px; color:#000; padding:0; margin:25px 0 20px 0; line-height:22px;">
                                Chào mừng quý Cán Bộ Y Tế <b>{{ $customer->getFullNameAttribute() }}</b>,
								</p>
                                <p style="font-family:arial,sans-serif;font-size:14px;color:#000;padding:0;line-height:24px;">
                                Chúng tôi xin trân trọng thông báo đăng kí của quý vị tại trang Miễn dịch ung thư đã hoàn tất. 
                                </p>
                                <p style="font-family:arial,sans-serif;font-size:14px;color:#000;padding:0;line-height:24px;">
                                Quý vị có thể bắt đầu sử dụng trang web bằng cách đăng nhập vào đường link: <br/> <a href="{{ url('login') }}">{{ url('login') }}</a>
                                </p>
                                <p style="font-family:arial,sans-serif;font-size:14px;color:#000;padding:0;line-height:24px;">
                                Nếu quý vị quên mật khẩu, quý vị có thể cài đặt lại bất cứ lúc nào bằng cách nhấn vào link: <br/> <a href="{{ url('password/reset') }}">{{ url('password/reset') }}</a>
                                </p>
                                <p style="font-family:arial,sans-serif; font-size:14px; color:#000; padding:0;margin: 20px 0 30px 0; line-height:24px;">
                                    <i>Đây là email tự động từ hệ thống, xin vui lòng không liên lạc qua email này.</i>
                                    <br/>
                                    Trân trọng, <br/>
                                    Ban quản trị trang Miễn dịch ung thư 
                                </p>
							</td>
						</tr>
						</tbody>
					</table>
				<!--[if gte mso 9]>
					</v:shape>
					<![endif]-->
				</td>
                </tr>
                <tr>
                    <td style=" background-color: rgb(246, 247, 248); ">
                        <p style="font-family:arial,sans-serif; font-size:12px; color:#000; padding:0; line-height:24px;text-align:center;padding: 10px 0;">
                            Copyright © 2020 {{ get_option('site_name') }}. All Rights Reserved.
                        </p>
                    </td>
                </tr>
        </tbody>
    </table>
</div>
</body>
</html>

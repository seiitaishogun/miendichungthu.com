<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div style="min-width:100%;width:100%!important;min-width:300px;max-width:100%;margin:0 auto;min-height:100%;padding:0px;background-color:#e8e8e8;">
    <table border="0" cellpadding="0" cellspacing="0" align="center" style="width: 650px;">
        <tbody>
            <tr>
                <td style=" background-color: rgb(246, 247, 248); ">
                    <!-- <img style="display: block; text-align: center; font-size: 24px;    margin: auto;padding: 10px 0;" src="https://theateam.vn/images/logo-mdut.svg" border="0" alt="Miễn Dịch Ung Thư" title="" width="430" height="135" /> -->
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
                                Chào mừng quý Cán Bộ Y Tế <b>{{ $customer->getFullNameAttribute() }}</b> đến với với trang Miễn dịch ung thư! 
								</p>
								<p style="font-family:arial,sans-serif;font-size:14px;color:#000;padding:0;line-height:24px;">
                                Chúng tôi đã nhận được thông tin đăng ký thành viên tại trang Miễn dịch ung thư của quý Cán Bộ Y Tế. Chúng tôi sẽ phản hồi lại quý Cán Bộ Y Tế về yêu cầu này trong thời gian sớm nhất.
								</p>
								<p style="font-family:arial,sans-serif;font-size:14px;color:#000;padding:0;line-height:24px;text-align:justify;">
                                Để hoàn tất đăng ký, quý vị vui lòng nhấp vào đường link bên dưới để xác nhận địa chỉ email này:
								</p>
                                <p style="font-family:arial,sans-serif;font-size:14px;color:#000;padding:0;">
                                    <a href="{{ $customer->getVerifyLink() }}" target="_blank" style="color: #ed1c24 text-decoration: none; outline: none;">{{ $customer->getVerifyLink() }}</a>
                                </p>
                                <p style="font-family:arial,sans-serif;font-size:14px;color:#000;padding:0;line-height:24px;">
                                Sau khi hoàn thành việc đăng ký, quý Cán Bộ Y Tế sẽ nhận được email thông báo từ hệ thống về việc truy cập website.
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

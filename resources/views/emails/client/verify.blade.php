<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0"
                    style="max-width:520px;background:#ffffff;border-radius:8px;
                   box-shadow:0 2px 8px rgba(0,0,0,.05);overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="padding:20px 24px;text-align:center;background:#000000;color:#ffffff;">
                            <h2 style="margin:0;font-size:20px;">
                                {{ config('app.name') }}
                            </h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px 24px;color:#333;text-align:center;">
                            <h3 style="margin-top:0;">
                                Verify Your Email Address
                            </h3>

                            <p style="font-size:14px;line-height:1.7;color:#555;margin-bottom:24px;">
                                Please click the button below to confirm your email address and activate your account.
                            </p>

                            <a href="{{ $url }}"
                                style="display:inline-block;padding:12px 28px;
                           background:#000000;color:#ffffff;
                           text-decoration:none;border-radius:4px;
                           font-size:14px;font-weight:bold;">
                                Verify Email
                            </a>

                            <p style="font-size:12px;color:#888;margin-top:30px;">
                                This verification link will expire in 30 minutes.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:15px 24px;text-align:center;background:#fafafa;color:#999;font-size:12px;">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>

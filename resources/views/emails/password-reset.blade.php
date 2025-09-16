@php
    $resetUrl = url('/reset-password-form?token=' . $token . '&email=' . urlencode($email));
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
</head>
<body style="background-color: #f4f6f8; font-family: Arial, sans-serif; margin: 0; padding: 40px;">

    <table align="center" cellpadding="0" cellspacing="0" width="100%"
           style="max-width: 600px; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); overflow: hidden;">

        <!-- Header -->
        <tr>
            <td style="background-color: #0d6efd; text-align: center; padding: 20px;">
                <h2 style="color: #ffffff; font-size: 24px; margin: 0;">🔑 Password Reset Request</h2>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 30px; text-align: center;">
                <p style="font-size: 16px; color: #333; margin-bottom: 25px;">
                    We received a request to reset your password for <strong>{{ config('app.name') }}</strong>.
                </p>

                <a href="{{ $resetUrl }}"
                   style="background-color: #0d6efd; color: #ffffff; padding: 14px 28px;
                          font-size: 16px; font-weight: bold; text-decoration: none;
                          border-radius: 6px; display: inline-block; box-shadow: 0 3px 6px rgba(13,110,253,0.3);">
                    Reset Password
                </a>

                <p style="font-size: 14px; color: #666; margin-top: 30px; line-height: 1.6;">
                    ⏳ This link will expire in <strong>3 hours</strong>. <br>
                    If you did not request a password reset, you can safely ignore this email.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f8f9fa; text-align: center; padding: 15px; font-size: 13px; color: #888;">
                Thanks,<br>
                <strong>{{ config('app.name') }}</strong><br>
                <small>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</small>
            </td>
        </tr>
    </table>

</body>
</html>

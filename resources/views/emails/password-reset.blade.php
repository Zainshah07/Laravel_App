<x-mail::message>
# Password Reset Request

We received a request to reset your password.

<x-mail::button :url="url('/reset-password-form?token=' . $token . '&email=' . urlencode($email))">
Reset Password
</x-mail::button>

This link will expire in 3 hours.

If you did not request a password reset, you can ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

<x-mail::message>
<div style="background-color: #f9f9f9; padding: 30px; border-radius: 10px; text-align: center; color: #333; font-family: Arial, sans-serif;">

<h1 style="color: #2c3e50; font-size: 26px; margin-bottom: 10px;">
    👋 Hello {{ $user->name }},
</h1>

<p style="font-size: 16px; line-height: 1.6; margin: 15px 0; color: #555;">
    We're excited to have you with us!
    Please verify your email address to activate your account and get started.
</p>

<x-mail::button :url="$url" style="background-color:#4CAF50; color:#fff; font-weight:bold; padding: 12px 24px; border-radius: 6px; font-size: 16px;">
Verify My Email
</x-mail::button>

<p style="font-size: 14px; color: #888; margin-top: 20px;">
    If you didn’t create an account, you can safely ignore this email.
</p>

<p style="margin-top: 30px; font-size: 14px; color: #555;">
    Thanks,<br>
    <strong style="color: #4CAF50;">{{ config('app.name') }}</strong>
</p>

</div>
</x-mail::message>

<x-mail::message>
<div style="background-color: #000; padding: 30px; border-radius: 10px; text-align: center; color: #fff;">

<h1 style="color: #00ff88; font-size: 28px; margin-bottom: 10px;">
    👋 Hello {{ $user->name }},
</h1>

<p style="font-size: 16px; line-height: 1.6; margin: 15px 0; color: #ddd;">
    We are excited to have you on board!
    Please verify your email address to activate your account and get started.
</p>

<x-mail::button :url="$url" style="background-color:#00ff88; color:#6bbd52; font-weight:bold; padding: 12px 24px; border-radius: 8px; font-size: 16px;">
Verify My Email
</x-mail::button>

<p style="font-size: 14px; color: #aaa; margin-top: 20px;">
    If you did not create an account, you can safely ignore this email.
</p>

<p style="margin-top: 30px; font-size: 14px; color: #777;">
    Thanks,<br>
    <strong style="color: #00ff88;">{{ config('app.name') }}</strong>
</p>

</div>
</x-mail::message>

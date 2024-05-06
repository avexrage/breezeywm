@component('mail::message')
# Halo!

Klik tombol di bawah untuk verifikasi email anda.

@component('mail::button', ['url' => $verificationUrl])
Verifikasi Email
@endcomponent

Jika anda tidak membuat akun, tidak diperlukan tindakan lebih lanjut.

@if (!empty($logoUrl))
![Logo]({{ $logoUrl }})
@endif

Salam,<br>
{{ config('app.name') }}

@endcomponent

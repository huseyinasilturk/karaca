@component('mail::message')
{{$information[0]["name"]}} Merhaba;
Sizi aramızda görmek güzel.
Sisteme giriş bilgileriniz.
Kullanıcı Adı :  {{$information[0]["user_name"]}}
Şifre :   {{$information[0]["password"]}}

@component('mail::button', ['url' => 'localhost:8000/login'])
Sisteme Gir
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

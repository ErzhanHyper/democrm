@component('mail::message')
# Приветствую!

Спасибо за регистрацию. Этот пароль был сгенерирован для входа: **{{ $password }}**

Вы можете изменить его в профиле

@component('mail::button', ['url' => 'http://laracrm/#/login'])
Войти
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent

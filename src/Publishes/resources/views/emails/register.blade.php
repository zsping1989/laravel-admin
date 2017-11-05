@component('mail::message')
# 用户注册激活
{{array_get($user,'name',array_get($user,'uname'))}} 您好:<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您用 {{ config('app.name', 'LaravelAdmin') }} 注册了本站账号
<br/>
请在1 小时内点击此链接以完成激活 {{$url}}

@component('mail::button', ['url' => $url])
激活用户
@endcomponent

谢谢,{{ config('app.name') }}
@endcomponent

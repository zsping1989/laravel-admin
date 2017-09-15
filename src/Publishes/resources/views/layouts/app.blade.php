<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @yield('css')
    <script>
        window.datas = {!! $data !!};
    </script>
</head>
<body>
@yield('content')
</body>
</html>

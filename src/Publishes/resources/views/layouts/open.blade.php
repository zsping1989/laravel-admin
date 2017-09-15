@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/ionicons/font-awesome.css') }}">
    <link rel="stylesheet" href="{{asset('/css/AdminLTE.min.css')}}">
    <style>
        html,body{
            background: #d2d6de;
        }
    </style>
@endsection
@section('content')
    <div id="app">
        <{{$page}}></{{$page}}>
    </div>

    <script src="{{ mix('/js/open/app.js') }}" type="application/javascript"></script>
@endsection

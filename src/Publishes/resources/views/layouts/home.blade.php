@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/ionicons/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap.css') }}">
@endsection
@section('content')
    <div class="hold-transition skin-blue layout-top-nav wrapper" id="app">
        <main-alert></main-alert>
        <main-modal></main-modal>
        <main-header></main-header>
        <div class="content-wrapper">
            <div class="container">
                <breadcrumb></breadcrumb>
                <{{$page}}></{{$page}}>
            </div>
        </div>
        <main-footer></main-footer>
    </div>
    <script src="{{ mix('/js/home/app.js') }}" type="application/javascript"></script>
@endsection

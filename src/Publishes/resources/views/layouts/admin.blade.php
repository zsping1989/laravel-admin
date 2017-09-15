@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/ionicons/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap.css') }}">
@endsection
@section('content')
    <div class="skin-blue sidebar-mini wysihtml5-supported app" :class="{'sidebar-collapse':sidebarCollapse,'sidebar-open':!sidebarCollapse}" id="app">
        <main-alert></main-alert>
        <main-modal></main-modal>
        <div class="wrapper">
            <main-header></main-header>
            <main-sidebar></main-sidebar>
            <div class="content-wrapper">
                <breadcrumb></breadcrumb>
                <{{$page}}></{{$page}}>
            </div>
            <main-footer></main-footer>
            <control-sidebar></control-sidebar>
        </div>
    </div>
    <script src="{{ mix('/js/admin/app.js') }}" type="application/javascript"></script>
@endsection

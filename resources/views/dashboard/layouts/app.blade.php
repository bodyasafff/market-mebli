<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.6">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>{{ config('app.name', 'Laravel') }} - @yield('head_title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/base/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/fonts/roboto.min.css') }}">

    @stack('css_2')

    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.amber-red.min.css" />
    <link rel="stylesheet" href="{{ asset('css/plugins/dialog-polyfill.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/mdl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/content.css') }}">

    @stack('css_1')
    @stack('css')
    @stack('head_js')

    <script src="{{ asset('js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/material.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dialog-polyfill.min.js') }}"></script>

</head>

@yield('main')

    <div id="preloader">
        <div style="margin: auto; width: 75px; height: 75px; position: relative; top: 50%; -webkit-transform: translateY(-50%); -ms-transform: translateY(-50%); transform: translateY(-50%);"><div class="md-preloader"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="75" width="75" viewbox="0 0 75 75"><circle cx="37.5" cy="37.5" r="33.5" stroke-width="8"/></svg></div></div>
    </div>

    <script src="{{ asset('js/base/func.js') }}"></script>
    <script src="{{ asset('js/web/base/viewPresenter.js') }}"></script> T

    <script src="{{ asset('js/base/repository.js') }}"></script>
    @include('dashboard.js-datasets')
    <script src="{{ asset('js/base/app.js') }}"></script>

    @stack('js')
</body>
</html>
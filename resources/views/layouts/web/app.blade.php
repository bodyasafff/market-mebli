<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title></title>

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/favicons/apple-touch-icon.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon-180x180.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}" />
    <link rel="manifest" href="{{ route('web.site.webmanifest') }}" />
    <link rel="mask-icon" href="{{ asset('images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />

    <link rel="amphtml" href="{{ str_replace('://', '://amp.', request()->fullUrl()) }}">
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property='article:author' content='' />
    <meta property='article:publisher' content='' />
    <meta property='article:published_time' content='' />
    <meta property='article:modified_time' content='' />
    <meta property="article:tag" content="">
    <meta property="article:section" content="" />
    <meta property="og:url" content="{{ request()->fullUrl() }}" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />

    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="og:description" content="" />
    <meta property="og:locale" content="" />

    <link rel="stylesheet" href="{{ asset('css/web.css') }}">
    @stack('css_base')
    @stack('css')

</head>

@yield('layout')

    @stack('js')
    @include('web.widget.json-app')
    @stack('json')
</body>
</html>
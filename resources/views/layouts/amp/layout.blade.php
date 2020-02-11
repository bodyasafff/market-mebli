@extends('layouts.amp.app')

@section('layout')
    <body>
    <div class="layout">
        @yield('content')
    </div>
@endsection

@push('css_base')
    @include('web.widget.css.layout-css')
    @if(false) <style> @endif
        @media screen and (max-width: 420px) {
            .round_border_block .image_block{
                float: none;
                width: 100%;
            }
        }
    @if(false) </style> @endif
@endpush
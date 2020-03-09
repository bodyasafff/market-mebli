@extends('layouts.web.app')

@section('layout')
    <body>
    <div class="head">
        <div class="head-logo">
            <a class="head-logo-a" href="{{ route('home') }}">
                <label>Маркет Меблі</label>
            </a>
        </div>
        <div class="head-icons">
            <input placeholder="Пошук" class="head-icons-search-input" type="text">
        </div>
    </div>
    @yield('content')
@endsection

@push('css_base')
    <script src="{{ asset('js/plugins/jquery-3.4.1.min.js') }}"></script>
@endpush
@push('css')
    <style>
        .head{
            height: 90px;
        }
        .head-logo{
            float: left;
            width: 20%;
            height: 100%;
            text-align: center;
            background-color: #ba2222;
            color: white;
            font-size: 30px;
            padding-top:17px;
            color: white;
        }
        .head-logo-a{
            color: white;
        }
        .head-logo-a:hover{
            color: darkorange;
            transition: 0.3s;
        }
        .head-icons{
            float: right;
            height: 100%;
            background-color: #2d2e2d;
            width: 80%;
        }
        .head-icons-search-input{
            margin-top: 25px;
            margin-left: 40%;
            width: 35%;
            background-color: #828282;
            border-radius: 20px;
            height: 35px;
            padding-left: 40px;
        }
        .head-icons-search-input::-webkit-input-placeholder{
            color: #1f1b1b;
        }
    </style>
@endpush
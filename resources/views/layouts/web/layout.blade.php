@extends('layouts.web.app')
@php
App::setLocale($_COOKIE['language']);
@endphp
@section('layout')
    <body>
    <div class="head">
        <div class="head-logo">
            <a class="head-logo-a" href="{{ route('home') }}">
                <label>Маркет Меблі</label>
            </a>
        </div>
        <div class="head-icons">
            <input type="button" class="catalog-products-btn" value="{{ trans('web.catalog_products')}}">
            <div class="head-icons-phone">+38(099) 569-87-45</div>
            <div class="head-icon">
                <img  src="{{url('')}}./images/icon/person-icon.png">
                <img  src="{{url('')}}./images/icon/basket-icon.png">
                <div class="head-icon-language">
                    <img id="language-icon"  src="{{url('')}}./images/icon/languege-icon.png">
                    <div class="head-icon-language-button">
                        <button onclick="transletePage(this)">en</button>
                        <button onclick="transletePage(this)">ru</button>
                        <button onclick="transletePage(this)">pl</button>
                        <button onclick="transletePage(this)">ua</button>
                    </div>
                </div>
                <img  src="{{url('')}}./images/icon/city-icon.png">
            </div>
            <input placeholder="{{trans('web.seacrh')}}" class="head-icons-search-input" type="text">

        </div>
    </div>

    @yield('content')
    @endsection
    @push('css_base')
        <script src="{{ asset('js/plugins/jquery-3.4.1.min.js') }}"></script>
    @endpush

    @push('js')
        <script>
            function transletePage(t) {
                document.cookie = 'language='+ t.innerHTML;
                location.reload();
            }

        </script>
    @endpush
    @push('css')
        <style>
            .head {
                height: 90px;
            }
            .head-logo {
                float: left;
                width: 20%;
                height: 100%;
                text-align: center;
                background-color: #ba2222;
                color: white;
                font-size: 30px;
                padding-top: 17px;
                color: white;
            }

            .head-logo-a {
                color: white;
            }

            .head-logo-a:hover {
                color: darkorange;
                transition: 0.3s;
            }

            .head-icons {
                float: right;
                height: 100%;
                background-color: #2d2e2d;
                width: 80%;
            }
            .catalog-products-btn{
                /*width: 10%;*/
                margin-left: 2%;
                margin-top: 25px;
                background-color: #2d2e2d;
                color: white;
                border: solid 1px white;
                padding: 5px 10px;
                border-radius: 15px;
            }
            .catalog-products-btn:hover{
                background-color: white;
                color: #2d2e2d;
                transition: 0.3s;
            }
            .head-icons-phone{
                color: white;
                float: right;
                margin-top: 30px;
                margin-right: 2%;
            }
            .head-icons-search-input {
                float: right;
                cursor: pointer;
                margin-top: 25px;
                width: 20%;
                background-color: #828282;
                border-radius: 20px;
                height: 35px;
                padding-left: 40px;
            }

            .head-icons-search-input::-webkit-input-placeholder {
                color: #1f1b1b;
            }
            .head-icon{
                margin-top: 30px;
                float: right;
                margin-right: 2%;
                display: flex;
            }
            .head-icon img {
                cursor: pointer;
                width: 25px;
                margin-left: 20px;
                /*margin-left: calc((100% - 75px) * 0.25);*/
                /*width: 25px;*/
            }
            .head-icon-language {
                cursor: pointer;
                width: 25px;
                margin-left: 20px;
                position: relative;
            }

            .head-icon-language img{
                margin: 0;
            }
            .head-icon-language-button{
                max-height: 0;
                overflow: hidden;
                position: absolute;
                transition: 0.4s;
            }
            .head-icon-language:hover .head-icon-language-button {
                max-height: 200px;
            }
            .head-icon-language-button button{
                width: 30px;
                text-align: center;
                outline: none;
                border: solid 3px transparent;
                margin: 2px auto;
                background: #817f83;
                border-radius: 2px;
                color: white;
            }
            .head-icon-language-button button:hover{
                color: #2d2e2d;
                background: #706e60;
                
            }

        </style>
    @endpush
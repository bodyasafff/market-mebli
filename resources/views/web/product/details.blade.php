@extends('layouts.web.layout')
@php
    if(isset($_COOKIE['language'])){
    App::setLocale($_COOKIE['language']);
    }
    else{
    $_COOKIE['language'] = 'ua';
    }
@endphp
@section('content')
    @include('web.widget.pop-up-product-catalog')
    <div class="product-container">
        <div class="product-header">
            <div class="product-breadcrumb"></div>
            <p class="product-article">{{ trans('web.article') .': '. $product->id}}</p>
        </div>
        <h2 class="product-name">{{ $product->{'name_'.$_COOKIE['language']} }}</h2>
        <div class="product-content">
            <div class="product-content-photo">
                @include('web.widget.images-detail-product')
            </div>
            <div class="product-content-info">
                <div class="product-content-info-container">
                    <div class="product-content-detail-info">
                        <div class="detail-info-price-container">
                            <div>
                                <p class="product-price">{{ $product->price }}</p>
                            </div>
                            <div class="product-detail-button-div">
                                <button class="product-content-button-buy">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                                         fill="white">
                                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                        <path d="M0 0h24v24H0z" fill="none"/>
                                    </svg>
                                    Купити
                                </button>
                            </div>
                        </div>
                        <div class="detail-info-color-container">
                            <div>
                                <p>
                                    Колір
                                </p>
                                <select class="color-select">
                                    <option disabled hidden selected>color</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                            <div class="product-detail-button-div">
                                <button class="product-content-button-buy-one-click">Купити in one click</button>
                            </div>
                        </div>
                    </div>
                    <div class="product-content-detail-info">
                        <select class="delivery-select">
                            <option disabled selected hidden>Dostavka v rivne</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                        <p>Швидкість, вартість, обережне поводження — наші послуги задовольнять будь-які потреби.
                            Оберіть єдиного партнера для міжнародних та внутрішніх відправлень. Відправлення в 5
                            кроків. </p>
                    </div>
                    <div class="product-content-detail-info">
                        <p>{{$product->data_product->{'description_'.$_COOKIE['language']} }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  TODO: inStock
                                  <p class="product-stock">{{ trans('web.availability_in_stock') }}</p>
                                  <div>{{ $product->availability_in_stock == 1? trans('web.available') :trans('web.not_available')}}</div>
    --}}
@endsection
@push('css')
    <style>
        .product-container {
            width: 95%;
            margin: auto;
        }

        .product-header {
            width: 100%;
            display: inline-block;
        }

        .product-article {
            margin: 20px 3%;
            float: right;
            font-family: sans-serif;
            font-size: 14px;
            padding: 7px 35px;
            border: solid 1px grey;
            border-radius: 15px;
        }

        .product-name {
            font-family: sans-serif;
            font-weight: bold;
            width: 80%;
        }

        .product-content {
            margin: 30px auto;
            display: flex;
        }

        .product-content > div {
            width: 48%;
            float: left;
        }

        .product-content > div:first-of-type {
            border-right: solid 1px grey;
            margin-left: 2%;
        }

        .product-content > div:last-of-type {
            margin-left: 5px;
        }

        .product-content-photo {
            display: flex;
        }

        .product-select-img {
            width: 15%;
            margin-left: 5%;
            max-height: 80vh;
            overflow: auto;
            padding: 4px;
        }

        .product-select-img::-webkit-scrollbar-track {

            border-radius: 3px;
            background-color: transparent;
        }

        .product-select-img::-webkit-scrollbar {
            width: 3px;
            background-color: transparent;
        }

        .product-select-img::-webkit-scrollbar-thumb {
            border-radius: 15px;
            background-color: #a1a1a1;
        }

        .product-select-img::-webkit-scrollbar-thumb:hover {
            border-radius: 15px;
            background-color: #000;
        }

        .product-select-img div {
            border: solid 1px grey;
            padding: 5px;
        }

        .product-select-img div:not(:first-of-type) {
            margin-top: 10px;
        }

        .product-select-img img {
            width: 100%;
        }

        .product-main-img {
            width: 75%;
            margin-left: 5%;
        }

        .product-main-img img {
            width: 95%;
        }


        /*    ----------------------------------------------*/

        .product-content-info {
            background: #e4e4e4;
            color: #8e837a;
        }

        .product-content-info-container {
            margin: 1%;
        }

        .product-content-detail-info {
            margin: 2px;
            background: white;
            padding: 20px;
        }

        .product-content-detail-info p {
            margin: 0;
        }

        .detail-info-color-container p {
            text-align: center;
        }

        .detail-info-color-container, .detail-info-price-container {
            display: flex;
        }

        .product-price {
            color: red;
            font-size: 35px;
            display: flex;
        }

        .product-price:after {
            content: ' $';
        }

        .product-detail-button-div {
            align-self: center;
            width: -webkit-fill-available;
            text-align: center;
        }

        .product-content-button-buy {
            height: 30px;
            padding: 5px 15px;
            background: red;
            outline: none;
            border: none;
            border-radius: 9px;
            color: white;
            font-weight: bold;
            font-size: 14px;
            align-self: center;
        }

        .color-select {
            text-align-last: center;
            min-width: 80px;
            padding: 5px 25px 5px 7px;

        }

        .product-content-button-buy-one-click {
            height: 30px;
            padding: 5px 15px;
            background: red;
            outline: none;
            border: none;
            border-radius: 9px;
            color: white;
            font-weight: bold;
            font-size: 14px;
            align-self: flex-end;
        }



        .delivery-select {
            min-width: 150px;
            text-align-last: center;
            padding: 5px 25px 5px 7px;
        }
    </style>
@endpush
@push('js')
    <script>
        function openDialogWindowCatalog() {
            $("#pop-up-product-catalog-close-div").attr('class', 'pop-up-product-catalog-close-div-visibilty');
            $("#close-pop-up-btn").attr('class', 'close-pop-up-btn');
            $("body").attr('style','position : relative;');
            document.getElementById("pop-up-product-catalog").open = true;
        };
    </script>
@endpush
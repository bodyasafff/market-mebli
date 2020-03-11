@extends('layouts.web.layout')
@php
    if(isset($_COOKIE['language'])){
    App::setLocale($_COOKIE['language']);
    }
@endphp
@section('content')
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
                    <div>
                        <p class="product-price">{{ $product->price }}</p>
                        <button class="product-content-button-buy">Купити</button>
                    </div>
                    <div>
                        <p class="product-stock">{{ trans('web.availability_in_stock') }}</p>
                    </div>
                    <div>
                        <p>{{$product->data_product->{'description_'.$_COOKIE['language']} }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            margin-left:2%;
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
        }

        .product-content-info-container {
            margin: 1%;
        }

        .product-content-info-container div {
            margin: 2px;
            background: white;
            display: flex;
        }

        .product-content-info-container div p {
            margin: 5px;
        }

        .product-price {
            color: red;
            font-size: 25px;
        }

        .product-price:after {
            content: ' $';
        }
        .product-content-button-buy{
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
    </style>
@endpush
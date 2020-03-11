@extends('layouts.web.layout')
@php
    if(isset($_COOKIE['language'])){
    App::setLocale($_COOKIE['language']);
    }
    else{
    $_COOKIE['language'] = 'ua';
    }
@endphp
@include('web.widget.pop-up-product-catalog')
@section('content')
<h1>{{ $product->{'name_'.$_COOKIE['language']} }}</h1>
<h2>{{ $product->price }}</h2>

<h2>{{ trans('web.article') .' '. $product->id}}</h2>


<div>{{ trans('web.availability_in_stock')}}</div>
<div>{{ $product->availability_in_stock == 1? trans('web.available') :trans('web.not_available')}}</div>

@include('web.widget.images-detail-product')
<h3>{{$product->data_product->{'description_'.$_COOKIE['language']} }}</h3>
@endsection
@push('css')
    <style>

    </style>
@endpush
@push('js')
    <script>
        $("#product_catalog").on('click',function () {
           $("#pop-up-product-catalog-close-div").attr('class', 'pop-up-product-catalog-close-div-visibilty');
           $("#close-pop-up-btn").attr('class', 'close-pop-up-btn');
           document.getElementById("pop-up-product-catalog").open = true;
        })
    </script>
@endpush
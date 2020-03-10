@extends('layouts.web.layout')
@php
    if(isset($_COOKIE['language'])){
    App::setLocale($_COOKIE['language']);
    }
@endphp
@section('content')
<h1>{{ $product->{'name_'.$_COOKIE['language']} }}</h1>
<h2>{{ $product->price }}</h2>

<h2>{{ trans('web.article') .' '. $product->id}}</h2>


<h2>{{ trans('web.availability_in_stock') }}</h2>

@include('web.widget.images-detail-product')
<h3>{{$product->data_product->{'description_'.$_COOKIE['language']} }}</h3>
@endsection
@push('css')
    <style>

    </style>
@endpush
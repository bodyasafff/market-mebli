@extends('layouts.web.layout')

@section('content')
    <div class="container" style="margin-top: 100px">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
           @include('web.widget.images-detail-product')
            @include('web.widget.product-details-data')
            </div>
        </div>
    </div>
@endsection
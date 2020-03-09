
@extends('dashboard.layouts.content')
@include('widget.form.push-resources')

@section('title') Замовлення @endsection

@section('content')

<div class="mdl-grid">
<div class="base-data-table mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
    <table class="mdl-data-table mdl-js-data-table">

    <tr><td>Номер:</td><td>{{$model->id}}</td></tr>
    <tr><td>Дата створення:</td><td>{{$model->created_at}}</td></tr>
    <tr><td>Підрозділ створення:</td><td>{{$model->creation_unit ? $model->creation_unit->name : ''}}</td></tr>
        <tr><td>Стан:</td><td>{{$model->state ? $model->state->name : ''}}</td></tr>
    <tr><td>Ціна виробника:</td><td>{{$model->price_producer ? $model->price_producer : ''}}</td></tr>
    <tr><td>Ціна зміни:</td><td>{{$model->price_producer ? $model->price_producer : ''}}</td></tr>
    <tr><td>Місце перебування:</td><td>{{$model->product_location ? $model->product_location->name : ''}}</td></tr>
    <tr><td>Імя клієнта:</td><td>{{$model->client ? $model->client->name : ''}}</td></tr>
    <tr><td>Прізвище:</td><td>{{$model->client ? $model->client->surname : ''}}</td></tr>
    <tr><td>По батькові:</td><td>{{$model->client ? $model->client->middle_name : ''}}</td></tr>
    <tr><td>Номер телефону клієнта:</td><td>{{$model->client ? $model->client->phone : ''}}</td></tr>
    <tr><td>Спосіб оплати:</td><td>{{$model->payment_method ? $model->payment_method->name : ''}}</td></tr>
    <tr><td>Спосіб проплати:</td><td>{{$model->payment_status ? $model->payment_status->name : ''}}</td></tr>
    <tr><td>Дата проплати:</td><td>{{$model->date_payment ? $model->date_payment : ''}}</td></tr>
    <tr><td>Документ про проплату:</td><td>{{$model->payment_document ? $model->payment_document : ''}}</td></tr>
    <tr><td>Перевізник:</td><td>{{$model->delivery ? $model->delivery->name : ''}}</td></tr>
        <tr><td>Дата відправлення:</td><td>{{$model->date_departure ? $model->date_departure : ''}}</td></tr>
    <tr><td>Дата прибуття:</td><td>{{$model->date_arrival ? $model->date_arrival : ''}}</td></tr>
    <tr><td>Статус перевізника:</td><td>{{$model->delivery_status ? $model->delivery_status->name : ''}}</td></tr>
    <tr><td>Статус клієнта:</td><td>{{$model->client_status ? $model->client_status->name : ''}}</td></tr>
    <tr><td>Підрозділ повернення:</td><td>{{$model->client_status ? $model->client_status->name : ''}}</td></tr>
    <tr><td>Підрозділ повернення:</td><td>{{$model->return_location ? $model->return_location->name : ''}}</td></tr>

   </table>
</div>
    <div class="base-data-table mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
        <table id="data-table" class="mdl-data-table mdl-js-data-table" style="width: 100%">
            <thead>
            <tr>
                <th style="width: 1px">id</th>
                <th style="width: 1px"></th>
                <th>Назва</th>
                <th style="width: 1px"></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('css')
    <style>
        .pagination{
            float: right;
            margin-top: 30px;
        }
        .dataTables_processing{
            position: fixed;
        }
        .dataTables_length{
            margin-top: 30px;
        }
    </style>
@endpush
@push('js')
    <script>
        $('#data-table').DataTable({
            "info": false,
            "ordering": false,
            "searching": false,
            "lengthChange": false,

        });

        @if($model->id)
            @foreach($model->products as $product)
            $('#data-table').dataTable().fnAddData([
                {{$product->id}},
                '<img onerror="this.src=\'' + defaultImageUrl + '\'" class="width-50 ' + ('{{$product->image}}' ? 'cursor-pointer' : '') + '" id="image_' + '{{$product->id}}' + '" src="' + ( '{{$product->image}}' ? baseAdminImageUrl  +'{{$product->image}}' : defaultImageUrl) + '" style="max-width:70px" onclick="showDialogEditImage(this, true)">',
                '{{$product->name_ua}}',
                '<label>Кількість   </label><label>'+ '{{$product->pivot->count}}' +'</label>',
            ])
            @endforeach
        @endif
    </script>
    <script src="{{ asset('js/base/datatable.js') }}"></script>
@endpush
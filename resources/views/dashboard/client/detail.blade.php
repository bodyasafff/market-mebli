@include('widget.form.pop-up-order-detail',['minWidth' => '80%'])
@extends('dashboard.layouts.content')
@include('widget.form.push-resources')

@section('title') Клієнт @endsection

@section('content')

    <input type="hidden" id="client_id-filter-input" value="{{$model->id}}">
    <div>
    <label class="detail-label-info">Імя: {{$model->name}}</label>
    <label class="detail-label-info">Прізвище: {{$model->surname}}</label>
    <label class="detail-label-info">По батькові: {{$model->middle_name}}</label>
    <label class="detail-label-info">Номер телефону: {{$model->phone}}</label>
        <label class="detail-label-info">Країна: {{$model->country}}</label>
        <label class="detail-label-info">Місто: {{$model->city}}</label>
        <label class="detail-label-info">Вулиця: {{$model->street}}</label>
        <label class="detail-label-info">Будинок: {{$model->house}}</label>
        <div class="base-data-table mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
            <table id="data-table" class="mdl-data-table mdl-js-data-table" style="width: 100%;z-index: 0"></table>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .detail-label-info{
            padding: 20px;
            font-size: 30px;
            display: block;
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('#data-table-pop-up').DataTable({
                "info": false,
                "ordering": false,
                "searching": false,
                "lengthChange": false,

            })
            $('#data-table').on('dblclick','tr',function (event) {
                orderID = $(this).children('td').slice(0, 1).text();
                $("#pop-up-order-detail-close-div").attr('class','pop-up-order-detail-close-div-visibilty');
                $("#close-pop-up-btn").attr('class','close-pop-up-btn');
                document.getElementById("pop-up-order-detail").open = true;

                $.ajax({
                    url: defaultUrl + '/dashboard/client/' + orderID+ '/order-detail',
                    type: "GET",
                    success: function (data) {
                        var order = JSON.parse(data);
                        document.getElementById("order_id").textContent = order.id;
                        document.getElementById("order_created_at").textContent = order.created_at;
                        document.getElementById("order_creation_unit").textContent = order.creation_unit ? order.creation_unit.name : '';
                        document.getElementById("order_state").textContent = order.state ? order.state.name : '';
                        document.getElementById("order_price_producer").textContent = order.price_producer ? order.price_producer : '';
                        document.getElementById("order_price_change").textContent = order.price_change ?  order.price_change : '';
                        document.getElementById("order_product_location").textContent = order.product_location ? order.product_location.name : '';
                        document.getElementById("order_payment_method").textContent = order.payment_method ? order.payment_method.name : '';
                        document.getElementById("order_payment_status").textContent = order.payment_status ? order.payment_status.name : '';
                        document.getElementById("order_date_payment").textContent = order.date_payment ? order.date_payment : '';
                        document.getElementById("order_payment_document").textContent = order.payment_document ? order.payment_document : '';
                        document.getElementById("order_delivery").textContent = order.delivery ? order.delivery.name : '';
                        document.getElementById("order_date_departure").textContent = order.date_departure ? order.date_departure : '';
                        document.getElementById("order_date_arrival").textContent = order.date_arrival ? order.date_arrival : '';
                        document.getElementById("order_delivery_status").textContent = order.delivery_status ? order.delivery_status.name : '';
                        document.getElementById("order_client_status").textContent = order.client_status ? order.client_status.name : '';
                        document.getElementById("order_return_location").textContent = order.return_location ? order.return_location.name : '';
                        $('#data-table-pop-up').dataTable().fnClearTable();
                        for (let i = 0;i < order.products.length;i++){
                            $('#data-table-pop-up').dataTable().fnAddData([
                                order.products[i].id,
                                '<img onerror="this.src=\'' + defaultImageUrl + '\'" class="width-50 ' + (order.products[i].image ? 'cursor-pointer' : '') + '" id="image_' + order.products[i].id + '" src="' + ( order.products[i].image ? baseAdminImageUrl  +order.products[i].image : defaultImageUrl) + '" style="max-width:70px" onclick="showDialogEditImage(this, true)">',
                                order.products[i].name_ua,
                                '<label>Кількість   </label><label>'+ order.products[i].pivot.count +'</label>',
                            ])
                        }

                    },
                    error: function (error) {
                        console.log(error);
                    }
                })
            });
        });

        $(function () {
            $.fn.dataTable.ext.errMode = 'throw';
            $.fn.DataTable.ext.pager.numbers_length = 6;

            dataTable = $('#data-table').DataTable({
                ajax: {
                    url: '{{ route('dashboard.client.detailJson') }}',
                    type: 'post'
                },
                order: [
                    [1, "desc"],
                ],
                columns: [
                    {
                        data: 'id',
                        title: 'id',
                        width: '1px',
                        className: 'mdl-data-table__cell--non-numeric id-cursor-pointer',
                    },
                    {
                        data: null,
                        name: '{{$model->id}}',
                        searchable: false,
                        orderable: false,
                        className: 'mdl-cell--hide',
                    },
                    {
                        data: 'created_at',
                        title: 'Дата створення',
                        width: '100%',
                        className: 'mdl-data-table__cell--non-numeric wrap',
                    },
                    {
                        data: 'creation_unit.name',
                        title: 'Підрозділ створення',
                        width: '100%',
                        className: 'mdl-data-table__cell--non-numeric wrap',
                        defaultContent: '',
                    },
                    {
                        data: 'payment_status.name',
                        title: 'Статус створення',
                        width: '100%',
                        className: 'mdl-data-table__cell--non-numeric wrap',
                        defaultContent: '',
                    },
                ],
                language: {
                    paginate: {
                        "first": "Перший",
                        "last": "Останній",
                        "next": "Наступний",
                        "previous": "Попередній"
                    },
                    lengthMenu: 'Показати <select>' +
                        '<option value="10">10</option>'+
                        '<option value="20">20</option>'+
                        '<option value="30">30</option>'+
                        '<option value="40">40</option>'+
                        '<option value="50">50</option>'
                },
                processing: true,
                serverSide: true,
                stateSave: true,
                dom: 'rtpl',
                lengthMenu: [[10, 25, 50], [10, 25, 50]]
            })
        })
        function deleteProductCategory(rowId) {
            if(confirm('Видалити?')){
                location.href = '/dashboard/client/'+rowId+'/destroy'
            }
        }
    </script>
    <script src="{{ asset('js/base/datatable.js') }}"></script>
@endpush
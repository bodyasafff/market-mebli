@include('dashboard.order.order-parts.order-pop-up-add-product',['minWidth'=>'80%'])
@include('dashboard.order.order-parts.order-pop-up-add-client',['minWidth'=>'80%'])
@extends('dashboard.layouts.content')
@include('widget.form.push-resources')

@section('title') Замовлення @endsection

@section('content')

    <form action="{{ route($model->id ? 'dashboard.order.update' : 'dashboard.order.store', [$model]) }}" method="post" enctype="multipart/form-data" class="mdl-grid">
        @csrf
        <input type="hidden" id="release_order_products" name="release_order_products" value="">

        @include('dashboard.order.order-parts.order-edit-tables')

        @include('dashboard.order.order-parts.order-edit-table-selects')

        @include('dashboard.order.order-parts.order-edit-selects-in-line')

        @include('widget.form.date-times')

        @include('widget.form.chosen-select-single', ['id' => 'price_change_id', 'title' => 'Зміна ціни', 'mdlCell' => [4, 8, 4],
          'options' => \App\Models\Orders\PriceChange::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
          'optionName' => 'name',
          'style' => 'height: 66px;margin:0;font-size:20px;margin-left:2%',
        ])

        @include('widget.form.textarea', ['id' => 'payment_document', 'title' => 'Документ про оплату', 'mdlCell' => [6, 8, 4], 'maxlength' => 255])
        <label for="payment_document_file" style="margin-top: 20px">
                <span class="mdl-button mdl-js-button" >
                    <i class="material-icons">save_alt</i>
                </span>
        </label>
        <input type="file" name="payment_document_file" id="payment_document_file" class="invisible" value="">
        <a href="{{$model->payment_document_file?url('').'/dashboard/order/'.$model->id.'/download-payment-document':''}}" style="{{$model->payment_document_file?'':'display:none'}}">Файл</a>

        @include('widget.form.chosen-select-single', ['id' => 'state_id', 'title' => 'Стан', 'mdlCell' => [12, 8, 4],
           'options' => \App\Models\Orders\State::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
           'optionName' => 'name',
           'style' => 'height: 66px; padding-bottom: 0; margin-bottom: 0;margin-left:2%; float: right;margin-right:2%',
        ])

        <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone footer">
            @include('widget.form.action-buttons', [
                'cancelUrl' => route('dashboard.order.index'),
           ])
        </div>
    </form>

    @if($model->id)
        <form id="destroy-form" action="{{ route('dashboard.order.destroy', [$model]) }}" method="GET" style="display: none;"> @csrf </form>
    @endif

@endsection
@push('css')
    <style>
        .select-div-first{
            border: solid 1px black;
            margin: 0;
            margin-left: 2%;
            margin-top: 30px;
        }
        .select-div{
            border: solid 1px black;
            margin: 0;
            margin-top: 30px;
        }
        .select-label-div{
            text-align: center;
            background-color:rgb(255,193,7);
            width: 100%;height: 30px;
            display: block;
            padding-top: 10px
        }
        .main-tabel-selects-div{
            margin: 0;
            margin-left: 2%;
            margin-right: 2%;
        }
        .tabel-selects-label{
            height: 20px;
            margin: 0;
            font-size:20px;
            float: left;
            padding-left: 20px;
            border-right: solid 1px gray;
            height: 30px;padding-top: 5px;
        }
        .tabel-selects-div{
            border-bottom: solid 1px gray;
            height: 30px;
        }
        .pagination{
            float: right;
            margin-top: 10px;
        }
        .dataTables_processing{
            position: fixed;
        }
        .dataTables_length{
            margin-top: 30px;
        }
        .fix-margin-table{
            margin-top: -12px;
        }
    </style>
@endpush
@push('js')
    <script>
        $('#data-table-release').addClass('fix-margin-table')
        $('#data-table-release').DataTable({
            "info": false,
            "ordering": false,
            "searching": false,
            "lengthChange": false,

        })

        $('#order-edit-add-product').on('click',function (event) {
            $("#pop-up-add-product-close-div").attr('class', 'pop-up-add-product-close-div-visibilty');
            $("#close-pop-up-btn").attr('class', 'close-pop-up-btn');
            document.getElementById("pop-up-add-product").open = true;
        });

        $('#order-edit-add-client').on('click',function (event) {
            $("#pop-up-add-client-close-div").attr('class', 'pop-up-add-product-close-div-visibilty');
            $("#close-pop-up-btn-client").attr('class', 'close-pop-up-btn');
            document.getElementById("pop-up-add-client").open = true;
        });

        @if($model->id)
        function editSetRealeseProducts(){
            @foreach($model->products as $product)
            $('#data-table-release').dataTable().fnAddData([
                {{$product->id}},
                '<img onerror="this.src=\'' + defaultImageUrl + '\'" class="width-50 ' + ('{{$product->image}}' ? 'cursor-pointer' : '') + '" id="image_' + '{{$product->id}}' + '" src="' + ( '{{$product->image}}' ? baseAdminImageUrl  +'{{$product->image}}' : defaultImageUrl) + '" style="max-width:70px" onclick="showDialogEditImage(this, true)">',
                '{{$product->name_ua}}',
                '<div ><label style="display:block; text-align: center;">Кількість</label><input type="number" style="width:50px" name="count_product_' + '{{$product->id}}' + '" value="'+ {{$product->pivot->count?$product->pivot->count:0}} +'">',
                '<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="removeRow(' + {{$product->id}} + ')">&nbsp;&nbsp;Видалити&nbsp;&nbsp;</button>'
            ]);

            var temp = $('#release_order_products').val();
            temp ? temp += ',' + '{{$product->id}}' : temp += '{{$product->id}}';
            $('#release_order_products').val(temp);
            @endforeach
        }
        editSetRealeseProducts();
        @endif

        $(function () {
            $('.mdl-layout--fixed-drawer').removeClass('mdl-layout--fixed-drawer');
            $.fn.dataTable.ext.errMode = 'throw';
            $.fn.DataTable.ext.pager.numbers_length = 6;

            dataTable = $('#data-table').DataTable({
                ajax: {
                    url: '{{ route('dashboard.product.indexJson') }}',
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
                        className: 'mdl-data-table__cell--non-numeric mdl-cell--hide-tablet mdl-cell--hide-phone',
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        className: 'datatable-row-properties-filter mdl-cell--hide',
                    },
                    {
                        data: null,
                        searchable: false,
                        orderable: false,
                        className: 'datatable-row-properties_only-filter mdl-cell--hide',
                    },
                    {
                        data: 'image',
                        title: '',
                        searchable: false,
                        orderable: false,
                        width: '1px',
                        className: 'mdl-data-table__cell--non-numeric center width-70',
                        render: function (data, type, row) {
                            return '<img onerror="this.src=\'' + defaultImageUrl + '\'" class="width-50 ' + (row.image ? 'cursor-pointer' : '') + '" id="image_' + row.id + '" src="' + (row.image ? baseAdminImageUrl+row.image : defaultImageUrl) + '" style="max-width:70px" onclick="showDialogEditImage(this, true)">';
                        }
                    },
                    {
                        data: 'name_ua',
                        title: 'Назва',
                        width: '100%',
                        className: 'mdl-data-table__cell--non-numeric wrap',
                    },
                    {
                        data: 'product_category_id',
                        title: 'product_category_id',
                        width: '1px',
                        className: 'datatable-row-product_category_id-filter mdl-cell--hide',
                    },
                    {
                        data: null,
                        width: '1px',
                        searchable: false,
                        orderable: false,
                        className: 'padding-left-0 btn-row',
                        render: function (data, type, row) {
                            return '<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="addProductId('+ row.id+')">&nbsp;&nbsp;Додати&nbsp;&nbsp;</button>';
                        },
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

                initComplete: function () {
                    dataTablesFunc.globalSearchFilter.initComplete(dataTable);
                    dataTablesFunc.selectFilter.initComplete(dataTable, 'product_category_id');
                    dataTablesFunc.selectFilter.initComplete(dataTable, 'properties');
                    dataTablesFunc.selectFilter.initComplete(dataTable, 'properties_only');
                    defaultChosenInit();
                },
                processing: true,
                serverSide: true,
                stateSave: true,
                dom: 'rtpl',
                lengthMenu: [[10, 25, 50], [10, 25, 50]]
            })
            dataTablesFunc.selectFilter.clickEventInit(dataTable, 'product_category_id');
            dataTablesFunc.selectFilter.clickEventInit(dataTable, 'properties');
            dataTablesFunc.selectFilter.clickEventInit(dataTable, 'properties_only');
        })




        function addProductId(id) {
            for(let i = 0;i < dataTable.ajax.json().data.length; i++){
                if(dataTable.ajax.json().data[i].id == id){
                    var flag = false;
                    var releseRows = $('#data-table-release').dataTable().fnGetData();

                    for(let j= 0;j < releseRows.length;j++)
                    {
                        if(releseRows[j][0] == id){
                            flag = true;
                        }
                    }
                    if(flag == false) {
                        $('#data-table-release').dataTable().fnAddData([
                            dataTable.ajax.json().data[i].id,
                            '<img onerror="this.src=\'' + defaultImageUrl + '\'" class="width-50 ' + (dataTable.ajax.json().data[i].image ? 'cursor-pointer' : '') + '" id="image_' + dataTable.ajax.json().data[i].id + '" src="' + (dataTable.ajax.json().data[i].image ? baseAdminImageUrl + dataTable.ajax.json().data[i].image : defaultImageUrl) + '" style="max-width:70px" onclick="showDialogEditImage(this, true)">',
                            dataTable.ajax.json().data[i].name_ua,
                            '<div ><label style="display:block; text-align: center;">Кількість</label><input type="number" style="width:50px" name="count_product_' + dataTable.ajax.json().data[i].id + '">',
                            '<button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="removeRow(' + dataTable.ajax.json().data[i].id + ')">&nbsp;&nbsp;Видалити&nbsp;&nbsp;</button>'
                        ]);
                        var temp = $('#release_order_products').val();
                        temp ? temp += ',' + id : temp += id;
                        $('#release_order_products').val(temp);
                    }else{
                        break;
                    }
                }
            }
        }

        function removeRow(id) {
            var table = document.getElementById("data-table-release");
            for (var i = 1, row; row = table.rows[i]; i++) {
                if(row.cells[0].textContent == id){
                    $('#data-table-release').dataTable().fnDeleteRow(row,null,true)
                }
            }

            var releaseProducts = $('#release_order_products').val();
            var temp = releaseProducts.split(',')
            for(let i = 0;i < releaseProducts.length;i++)
            {

                if(temp[i] == id)
                {
                    temp.splice(i,1);
                }
            }
            releaseProducts = temp.join(',');
            $('#release_order_products').val(releaseProducts);
            var test=  $('#release_order_products').val();
        }
    </script>
    <script src="{{ asset('js/base/datatable.js') }}"></script>
@endpush

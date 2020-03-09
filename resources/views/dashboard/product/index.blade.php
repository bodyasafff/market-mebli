@extends('dashboard.layouts.content')
@include('widget.form.push-resources')
@section('title') Продукти @endsection

@section('global-search-input')
    @include('widget.global-search-input')
@endsection

@include('widget.dialog-edit-image', ['isUpload' => false, 'isRemove' => false, 'minWidth' => '80%'])


@section('content')
    <div class="mdl-grid">

        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid">
            <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--2-col-phone">
                <a href="{{route('dashboard.product.create') }}" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="margin-top: 10px;background-color: #8bc34a">Новий продукт</a>
            </div>

            @include('widget.form.chosen-select-multiple', ['id' => 'properties', 'title' => 'Сортування', 'mdlCell' => [3, 4, 2],
               'options' =>  \App\Models\PropertyCategory::select(['id','name_ua'])->get(),
               'name' => 'properties_only-filter-select',
               'optionName' => 'name_ua',
               'cssClass' => 'search-choise-block',
               'group' => true,
             ])


            @include('widget.form.chosen-select-multiple', ['id' => 'properties', 'title' => 'Виберіть властивості', 'mdlCell' => [3, 4, 2],
              'options' =>  \App\Models\PropertyCategory::select(['id','name_ua'])->get(),
              'name' => 'properties-filter-select',
              'optionName' => 'name_ua',
              'cssClass' => 'search-choise-block',
              'group' => true,
            ])

            @include('widget.form.chosen-select-single', ['id' => 'product_category_id-filter-select', 'title' => 'Категорії', 'mdlCell' => [3, 4, 2],
                     'options' => \App\Models\ProductCategory::select(['id','name_ua'])->get()->prepend((object)['id' => '', 'name_ua' => '']),
                     'optionName' => 'name_ua',
            ])

        </div>


        <div class="base-data-table mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
            <table id="data-table" class="mdl-data-table mdl-js-data-table" style="width: 100%"></table>
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
        $(function () {
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
                            return '<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="location.href = \'/dashboard/product/' + row.id + '/edit\'">&nbsp;&nbsp;Редагувати&nbsp;&nbsp;</button>';
                        },
                    },
                    {
                        data: null,
                        width: '1px',
                        searchable: false,
                        orderable: false,
                        className: 'padding-left-0 btn-row',
                        render: function (data, type, row) {
                            return '<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="deleteProductCategory('+row.id+')">&nbsp;&nbsp;Видалити&nbsp;&nbsp;</button>';
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




        function deleteProductCategory(rowId) {
            if(confirm('Видалити?')){
                location.href = '/dashboard/product/'+rowId+'/destroy'
            }
        }
    </script>
    <script src="{{ asset('js/base/datatable.js') }}"></script>
@endpush
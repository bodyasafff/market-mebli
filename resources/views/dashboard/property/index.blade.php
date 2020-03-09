@extends('dashboard.layouts.content')
@include('widget.form.push-resources')
@section('title') Властивості @endsection


@section('global-search-input')
    @include('widget.global-search-input')
@endsection

@section('content')
    <div class="mainTable mdl-grid">


        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid">
            <div class="mdl-cell mdl-cell--9-col mdl-cell--4-col-tablet mdl-cell--2-col-phone">
                <a href="{{route('dashboard.property.create') }}" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="margin-top: 10px;background-color: #8bc34a">Нова властивість</a>
            </div>

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
                    url: '{{ route('dashboard.property.indexJson') }}',
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
                        data: 'name_ua',
                        title: 'Назва',
                        width: '100%',
                        className: 'mdl-data-table__cell--non-numeric wrap',
                    },
                    {
                        data: 'property_category_id',
                        title: 'property_category_id',
                        width: '1px',
                        className: 'datatable-row-property_category_id-filter mdl-cell--hide',
                    },
                    {
                        data: null,
                        width: '1px',
                        searchable: false,
                        orderable: false,
                        className: 'padding-left-0 btn-row',
                        render: function (data, type, row) {
                            return '<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="location.href = \'/dashboard/property/' + row.id + '/edit\'">&nbsp;&nbsp;Редагувати&nbsp;&nbsp;</button>';
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
                    dataTablesFunc.selectFilter.initComplete(dataTable, 'property_category_id');
                    defaultChosenInit();
                },
                processing: true,
                serverSide: true,
                stateSave: true,
                dom: 'rtpl',
                lengthMenu: [[10, 25, 50], [10, 25, 50]]
            })
            dataTablesFunc.selectFilter.clickEventInit(dataTable, 'property_category_id');
        })
        function deleteProductCategory(rowId) {
            if(confirm('Видалити?')){
                location.href = '/dashboard/property/'+rowId+'/destroy'
            }
        }
    </script>
    <script src="{{ asset('js/base/datatable.js') }}"></script>
@endpush
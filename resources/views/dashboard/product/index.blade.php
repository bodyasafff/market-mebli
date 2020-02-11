@extends('layouts.dashboard.content')
@section('title') Категорії продуктів @endsection

@section('global-search-input')
    @include('widget.global-search-input')
@endsection

@include('widget.dialog-edit-image', ['isUpload' => false, 'isRemove' => false, 'minWidth' => '80%'])

@section('content')
    <div class="mainTable mdl-grid">


        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid">
            <div class="mdl-cell mdl-cell--9-col mdl-cell--4-col-tablet mdl-cell--2-col-phone">
                <a href="{{route('dashboard.product-category.create') }}" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="margin-top: 10px;background-color: #8bc34a">Нова категорія продуктів
                    <span class="mdl-button__ripple-container" >
                <span class="mdl-ripple"></span>
            </span></a>
            </div>


        </div>
        <div class="base-data-table mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
            <table id="data-table" class="mdl-data-table mdl-js-data-table" ></table>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .pagination{
            float: right;
        }
        .dataTables_processing{
            position: fixed;
        }
    </style>
@endpush
{{--@push('js')--}}
{{--    <script>--}}
{{--        $(function () {--}}
{{--            $.fn.dataTable.ext.errMode = 'throw';--}}
{{--            $.fn.DataTable.ext.pager.numbers_length = 6;--}}

{{--            dataTable = $('#data-table').DataTable({--}}
{{--                ajax: {--}}
{{--                    url: '{{ route('dashboard.product-category.indexJson') }}',--}}
{{--                    type: 'post'--}}
{{--                },--}}
{{--                order: [--}}
{{--                    [1, "desc"],--}}
{{--                ],--}}
{{--                columns: [--}}
{{--                    {--}}
{{--                        data: 'id',--}}
{{--                        title: 'id',--}}
{{--                        width: '1px',--}}
{{--                        className: 'mdl-data-table__cell--non-numeric mdl-cell--hide-tablet mdl-cell--hide-phone',--}}
{{--                    },--}}
{{--                    {--}}
{{--                        data: 'image',--}}
{{--                        title: '',--}}
{{--                        searchable: false,--}}
{{--                        orderable: false,--}}
{{--                        className: 'mdl-data-table__cell--non-numeric center width-70',--}}
{{--                        render: function (data, type, row) {--}}
{{--                            return '<img onerror="this.src=\'' + defaultImageUrl + '\'" class="width-50 ' + (row.image ? 'cursor-pointer' : '') + '" id="image_' + row.id + '" src="' + (row.image ? baseAdminImageUrl+row.image : defaultImageUrl) + '" style="max-width:70px" onclick="showDialogEditImage(this, true)">';--}}
{{--                        }--}}
{{--                    },--}}
{{--                    {--}}
{{--                        data: 'name_ua',--}}
{{--                        title: 'Назва',--}}
{{--                        width: '100%',--}}
{{--                        className: 'mdl-data-table__cell--non-numeric wrap',--}}
{{--                    },--}}
{{--                    {--}}
{{--                        data: null,--}}
{{--                        width: '1px',--}}
{{--                        searchable: false,--}}
{{--                        orderable: false,--}}
{{--                        className: 'padding-left-0 btn-row',--}}
{{--                        render: function (data, type, row) {--}}
{{--                            return '<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" onclick="location.href = \'/dashboard/product-category/' + row.id + '/edit\'">&nbsp;&nbsp;Редагувати&nbsp;&nbsp;</button>';--}}
{{--                        },--}}
{{--                    },--}}
{{--                    {--}}
{{--                        data: null,--}}
{{--                        width: '1px',--}}
{{--                        searchable: false,--}}
{{--                        orderable: false,--}}
{{--                        className: 'padding-left-0 btn-row',--}}
{{--                        render: function (data, type, row) {--}}
{{--                            return '<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="deleteProductCategory('+row.id+')">&nbsp;&nbsp;Видалити&nbsp;&nbsp;</button>';--}}
{{--                        },--}}
{{--                    },--}}
{{--                ],--}}
{{--                language: {--}}
{{--                    paginate: {--}}
{{--                        "first": "Перший",--}}
{{--                        "last": "Останній",--}}
{{--                        "next": "Наступний",--}}
{{--                        "previous": "Попередній"--}}
{{--                    },--}}
{{--                    lengthMenu: 'Показати <select>' +--}}
{{--                        '<option value="10">10</option>'+--}}
{{--                        '<option value="20">20</option>'+--}}
{{--                        '<option value="30">30</option>'+--}}
{{--                        '<option value="40">40</option>'+--}}
{{--                        '<option value="50">50</option>'--}}
{{--                },--}}
{{--                processing: true,--}}
{{--                serverSide: true,--}}
{{--                stateSave: true,--}}
{{--                dom: 'rtpl',--}}
{{--                lengthMenu: [[10, 25, 50], [10, 25, 50]]--}}
{{--            })--}}

{{--        })--}}
{{--        function deleteProductCategory(rowId) {--}}
{{--            if(confirm('Видалити?')){--}}
{{--                location.href = '/dashboard/product-category/'+rowId+'/destroy'--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--    <script src="{{ asset('js/base/datatable.js') }}"></script>--}}
{{--@endpush--}}
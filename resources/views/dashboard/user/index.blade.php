@extends('layouts.dashboard.content')
@include('widget.datatable-push-resources')

@section('head_title') Users @endsection
@section('title') Users @endsection
@section('global-search-input')
    @include('widget.global-search-input')
@endsection

@include('widget.dialog-edit-image', ['isUpload' => false, 'isRemove' => false])

@section('content')


    <div class="mdl-grid">

        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid" style="padding: 0;">

            {{--@include('widget.form.date-time-picker', ['id' => 'created_at-from-filter-input', 'idBtn' => 'created_at-from-filter-btn', 'title' => 'Date Registered From', 'mdlCell' => [4, 4, 4]])
            @include('widget.form.date-time-picker', ['id' => 'created_at-to-filter-input', 'idBtn' => 'created_at-to-filter-btn', 'title' => 'Date Registered To', 'mdlCell' => [4, 4, 4]])
            <div class="mdl-cell mdl-cell--4-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>--}}

            @include('widget.form.text-input', ['id' => 'created_at-from-filter-input', 'title' => 'Date Updated From', 'mdlCell' => [4, 4, 2],
                'typeInput' => 'date',
            ])
            @include('widget.form.text-input', ['id' => 'created_at-to-filter-input', 'title' => 'Date Updated To', 'mdlCell' => [4, 4, 2],
                'typeInput' => 'date',
            ])

            <div class="mdl-cell mdl-cell--4-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>

            @include('widget.form.chosen-select-single', ['id' => 'status_id-filter-select', 'title' => 'Filter by status', 'mdlCell' => [4, 4, 2],
                'options' => \App\Models\Datasets\UserStatus::findAll(['id' => null, 'name' => null]),
                'style' => 'height: 66px; padding-bottom: 0; margin-bottom: 0;',
            ])

            @include('widget.form.chosen-select-single', ['id' => 'role_id-filter-select', 'title' => 'Filter by role', 'mdlCell' => [4, 4, 2],
                'options' => \App\Models\Datasets\UserRole::findAll(['id' => null, 'name' => null]),
                'style' => 'height: 66px; padding-bottom: 0; margin-bottom: 0;',
            ])

            <div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
                <a href="{{ route('dashboard.user.create') }}" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="margin-top: 10px; float: right;">Create New User</a>
            </div>
        </div>

        <div class="base-data-table mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
            <table id="data-table" class="mdl-data-table mdl-js-data-table"></table>
        </div>
    </div>
@endsection

@push('css_2')
    {{--<link rel="stylesheet" href="{{ asset('css/plugins/mdDateTimePicker.min.css') }}">--}}
@endpush
@push('js')
    {{--<script src="{{ asset('js/plugins/mdDateTimePicker.min.js') }}"></script>
    <script src="{{ asset('js/base/mdDateTimePicker.js') }}"></script>--}}
    <script type="text/javascript">
        $(function () {

            $.fn.dataTable.ext.errMode = 'throw';
            $.fn.DataTable.ext.pager.numbers_length = 6;

            dataTable = $('#data-table').DataTable({
                ajax: {
                    url: '{{ route('dashboard.user.index-json') }}',
                    type: 'post'
                },
                order: [
                    [10, "desc"],
                ],
                columns: [
                    {
                        data: null,
                        className: 'mdl-data-table__cell--non-numeric details-control padding-right-0',
                        defaultContent: '+',
                        searchable: false,
                        orderable: false,
                        width: "1px",
                        render: function (data, type, row) {
                            return '+';
                        }
                    },{
                        data: 'id',
                        title: 'id',
                        width: '1px',
                    },{
                        data: 'role_id',
                        title: 'role',
                        width: '1px',
                        className: 'mdl-data-table__cell--non-numeric center datatable-row-role_id-filter datatable-row-role_id-hide-filter',
                        render: function (data, type, row) {
                            return datasets.getNameById('userRole', row.role_id);
                        }
                    },{
                        data: 'name',
                        title: 'name',
                        width: '1px',
                        className: 'mdl-data-table__cell--non-numeric wrap mdl-cell--hide-tablet mdl-cell--hide-phone',
                    },{
                        data: 'email',
                        title: 'email',
                        width: '1px',
                        className: 'mdl-data-table__cell--non-numeric wrap mdl-cell--hide-tablet mdl-cell--hide-phone',
                    },{
                        data: 'status_id',
                        title: 'status',
                        width: '1px',
                        className: 'mdl-data-table__cell--non-numeric center datatable-row-status_id-filter datatable-row-status_id-hide-filter uppercase-all',
                        render: function (data, type, row) {
                            return '<span style="color: '+datasets.getParamById('userStatus', row.status_id, 'color')+'">'+datasets.getNameById('userStatus', row.status_id)+'</span>';
                        }
                    },{
                        data: null,
                        className: 'mdl-cell--hide datatable-row-created_at-from-filter',
                        searchable: false,
                        orderable: false,
                    },{
                        data: null,
                        className: 'mdl-cell--hide datatable-row-created_at-to-filter',
                        searchable: false,
                        orderable: false,
                    },{
                        data: 'created_at',
                        title: 'registered',
                        width: '120px',
                        searchable: false,
                        className: 'width-120 mdl-data-table__cell--non-numeric center wrap mdl-cell--hide-tablet mdl-cell--hide-phone',
                        render: function (data, type, row) {
                            return moment.utc(row.created_at).local().format("MMM DD, YYYY");
                        }
                    },{
                        data: 'updated_at',
                        title: 'activity at',
                        width: '120px',
                        searchable: false,
                        className: 'width-120 mdl-data-table__cell--non-numeric center wrap mdl-cell--hide-tablet mdl-cell--hide-phone',
                        render: function (data, type, row) {
                            return moment.utc(row.updated_at).local().format("MMM DD, YYYY, HH:mm");
                        }
                    },{
                        data: null,
                        width: '1px',
                        searchable: false,
                        orderable: false,
                        className: 'padding-left-0 btn-row',
                        render: function (data, type, row) {
                            return '<button class="mdl-button mdl-js-button mdl-button--raised" onclick="location.href = \'/dashboard/user/'+row.id+'/edit\'">EDIT</button>';
                        }
                    },{
                        data: null,
                        width: '1px',
                        searchable: false,
                        orderable: false,
                        className: 'padding-left-0 mdl-cell--hide-tablet mdl-cell--hide-phone',
                        render: function (data, type, row) {
                            if(row.status_id != {{ \App\Models\Datasets\UserStatus::BLOCKED }}) {
                                return '<button class="mdl-button mdl-js-button mdl-button--accent" onclick="userStatusUpdate(this, {{ \App\Models\Datasets\UserStatus::BLOCKED }})">Block</button>';
                            }
                            return '';
                        }
                    }
                ],
                initComplete: function () {
                    dataTablesFunc.globalSearchFilter.initComplete(dataTable);
                    dataTablesFunc.selectFilter.initComplete(dataTable, 'status_id');
                    dataTablesFunc.selectFilter.initComplete(dataTable, 'role_id');
                    /*dataTablesFunc.mdlDateTimePickerRangeFilter.initComplete(dataTable, 'created_at');*/
                    dataTablesFunc.dateRangeFilter.initComplete(dataTable, 'created_at');
                    defaultChosenInit();
                },
                processing: true,
                serverSide: true,
                stateSave: true,
                dom: 'rtipl',
                lengthMenu: [[10, 25, 50], [10, 25, 50]]
            });

            dataTable.on('draw.dt', function () {
                componentHandler.upgradeDom();
            });

            dataTablesFunc.detailsRow.init(dataTable, showDetailsRow);
            dataTablesFunc.selectFilter.clickEventInit(dataTable, 'status_id');
            dataTablesFunc.selectFilter.clickEventInit(dataTable, 'role_id');
            /*dataTablesFunc.mdlDateTimePickerRangeFilter.clickEventInit(dataTable, 'created_at');*/
            dataTablesFunc.dateRangeFilter.clickEventInit(dataTable, 'created_at');
        });

        function showDetailsRow(d) {
            return '';
        }

        function userStatusUpdate(e, status_id) {
            if(status_id === {{ \App\Models\Datasets\UserStatus::BLOCKED }}){
                if(!confirm('Block this user?')){
                    return;
                }
            }

            var tr = $(e).closest('tr');
            var row = dataTable.row(tr).data();

            $.ajax({
                url: baseAdminUrl+'user/'+row.id+'/ajax-update',
                method: "POST",
                data: {
                    status_id: status_id
                }
            }).done(function (response) {
                $(tr).find('.datatable-row-status_id-filter').text(datasets.getNameById('userStatus', status_id));
                showSnackbarDefault(response);
            }).fail(function () {
                showSnackbarDefault(false);
            });
        }


    </script>
    <script src="{{ asset('js/base/datatable.js') }}"></script>
@endpush

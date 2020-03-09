@extends('dashboard.dashboard.content')
@include('widget.form.push-resources')

@section('head_title') {{ $model->id ? 'Edit User №'.$model->id : 'Create New User' }} @endsection
@section('title')
    <a class="mdl-button mdl-button--icon" href="{{ route('dashboard.user.index') }}" style="color: white; margin-top: -5px;"><i class="material-icons">arrow_back</i></a>
    {{ $model->id ? 'Edit User №'.$model->id : 'Create New User' }}
@endsection

@include('widget.dialog-edit-image', ['isUpload' => false, 'isRemove' => false, 'minWidth' => '80%'])

@section('content')

<div class="base-form">
    <form action="{{ route($model->id ? 'dashboard.user.update' : 'dashboard.user.store', [$model]) }}" method="post" enctype="multipart/form-data" class="mdl-grid">
        @csrf
        <input type="hidden" name="id" value="{{ !empty($model->id) ? $model->id : '' }}">
        <input type="hidden" name="images_deleted" id="images_deleted_input" value="">

        @include('widget.form.text-input', ['id' => 'name', 'title' => 'Name', 'mdlCell' => [4, 3, 4], 'maxlength' => 100])
        @include('widget.form.text-input', ['id' => 'email', 'title' => 'Email', 'mdlCell' => [4, 3, 4], 'maxlength' => 100])
        @include('widget.form.text-input', ['id' => 'new_password', 'title' => 'New Password', 'mdlCell' => [4, 2, 4], 'maxlength' => 255])

        @include('widget.form.chosen-select-single', ['id' => 'role_id', 'title' => 'User Role', 'mdlCell' => [4, 3, 4],
            'options' => \App\Models\Datasets\UserRole::findAll(),
        ])
        @include('widget.form.chosen-select-single', ['id' => 'status_id', 'title' => 'User Status', 'mdlCell' => [4, 3, 4],
            'options' => \App\Models\Datasets\UserStatus::findAll(),
        ])

        <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone footer">
            @include('widget.form.action-buttons', [
                'cancelUrl' => route('dashboard.user.index'),
            ])
            @include('widget.form.time-log')
        </div>
    </form>

    @if($model->id)
        <form id="destroy-form" action="{{ route('dashboard.user.destroy', [$model]) }}" method="POST" style="display: none;"> @csrf </form>
    @endif
</div>
@endsection

@push('css')
    <style>
        .mdl-layout__header{
            background-color: rgb(96,125,139);
        }
    </style>
@endpush


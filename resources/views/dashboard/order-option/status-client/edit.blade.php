@extends('dashboard.layouts.content')
@include('widget.form.push-resources')

@section('title') Статус клієнтів @endsection

@section('content')

    <form action="{{ route($model->id ? 'dashboard.order_option.client_status.update' : 'dashboard.order_option.client_status.store', [$model]) }}" method="post" class="mdl-grid">
        @csrf

            @include('widget.form.textarea', ['id' => 'name', 'title' => 'Назва', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])

        <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone footer">
            @include('widget.form.action-buttons', [
                'cancelUrl' => route('dashboard.order_option.client_status.index'),
           ])
        </div>
    </form>

    @if($model->id)
        <form id="destroy-form" action="{{ route('dashboard.order_option.client_status.destroy', [$model]) }}" method="GET" style="display: none;"> @csrf </form>
    @endif

@endsection


@extends('dashboard.layouts.content')
@include('widget.form.push-resources')

@section('title') Статус замовлень @endsection

@section('content')

    <form action="{{ route($model->id ? 'dashboard.order_option.order_status.update' : 'dashboard.order_option.order_status.store', [$model]) }}" method="post" class="mdl-grid">
        @csrf

        @include('widget.form.textarea', ['id' => 'name', 'title' => 'Назва', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])

        <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone footer">
            @include('widget.form.action-buttons', [
                'cancelUrl' => route('dashboard.order_option.order_status.index'),
           ])
        </div>
    </form>

    @if($model->id)
        <form id="destroy-form" action="{{ route('dashboard.order_option.order_status.destroy', [$model]) }}" method="GET" style="display: none;"> @csrf </form>
    @endif

@endsection


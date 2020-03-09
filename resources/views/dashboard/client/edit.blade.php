@extends('dashboard.layouts.content')
@include('widget.form.push-resources')

@section('title') Клієнти @endsection

@section('content')

    <form action="{{ route($model->id ? 'dashboard.client.update' : 'dashboard.client.store', [$model]) }}" method="post" class="mdl-grid">
        @csrf

        @include('widget.form.textarea', ['id' => 'name', 'title' => 'Ім\'я', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'surname', 'title' => 'Прізвище', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'middle_name', 'title' => 'По батькові', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'phone', 'title' => 'Номер телефону', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'country', 'title' => 'Країна', 'mdlCell' => [3, 2, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'city', 'title' => 'Місто', 'mdlCell' => [3, 2, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'street', 'title' => 'Вулиця', 'mdlCell' => [3, 2, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'house', 'title' => 'Будинок', 'mdlCell' => [3, 2, 4], 'maxlength' => 255])
        <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone footer">
            @include('widget.form.action-buttons', [
                'cancelUrl' => route('dashboard.client.index'),
           ])
        </div>
    </form>

    @if($model->id)
        <form id="destroy-form" action="{{ route('dashboard.client.destroy', [$model]) }}" method="GET" style="display: none;"> @csrf </form>
    @endif

@endsection


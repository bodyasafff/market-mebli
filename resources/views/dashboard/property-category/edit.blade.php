@extends('dashboard.layouts.content')
@include('widget.form.push-resources')

@section('title') Категорії властивостей @endsection

@section('content')


    <form action="{{ route($model->id ? 'dashboard.property-category.update' : 'dashboard.property-category.store', [$model]) }}" method="post" class="mdl-grid">
        @csrf

        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid">
            @include('widget.form.chosen-select-single', ['id' => 'parent_property_category_id', 'title' => 'Головна категорія властивостей', 'mdlCell' => [3, 4, 2],
                 'options' => \App\Models\PropertyCategory::select(['id','name_ua'])->get()->prepend((object)['id' => '', 'name_ua' => '']),
                 'optionName' => 'name_ua',
                 'style' => 'height: 66px; padding-bottom: 0; margin-bottom: 0; float: right;',
            ])
            @include('widget.form.chosen-select-single', ['id' => 'group_id', 'title' => 'Группа', 'mdlCell' => [3, 4, 2],
                 'options' => \App\Models\Group::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
                 'optionName' => 'name',
                 'style' => 'height: 66px; padding-bottom: 0; margin-bottom: 0; float: right;',
            ])
        </div>
        @foreach(\App\Models\Datasets\Lang::all() as $lang)
            @include('widget.form.textarea', ['id' => 'name_'.$lang['id'], 'title' => 'Назва ('.$lang['id'].')', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
        @endforeach
        @include('widget.form.textarea', ['id' => 'weight', 'title' => 'Вага', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
        <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone footer">
            @include('widget.form.action-buttons', [
                'cancelUrl' => route('dashboard.property-category.index'),
           ])
        </div>
    </form>

    @if($model->id)
        <form id="destroy-form" action="{{ route('dashboard.property-category.destroy', [$model]) }}" method="GET" style="display: none;"> @csrf </form>
    @endif
@endsection
@extends('dashboard.layouts.content')
@include('widget.form.push-resources')

@section('title') Категорії продуктів @endsection

@section('content')

    @include('widget.dialog-edit-image', ['isUpload' => false, 'isRemove' => false, 'minWidth' => '80%'])

    <form action="{{ route($model->id ? 'dashboard.product-category.update' : 'dashboard.product-category.store', [$model]) }}" method="post" enctype="multipart/form-data" class="mdl-grid">
        @csrf
        <input type="hidden" name="images_deleted" id="images_deleted_input" value="">
        @include('widget.form.chosen-select-multiple', ['id' => 'property_categories', 'title' => 'Виберіть категорії властивостей', 'mdlCell' => [3, 4, 2],
            'options' =>  \App\Models\PropertyCategory::select(['id','name_ua'])->get(),
            'optionName' => 'name_ua',
            'cssClass' => 'search-choise-block',
        ])

        @include('widget.form.chosen-select-single', ['id' => 'parent_product_category_id', 'title' => 'Батькывська категорія', 'mdlCell' => [3, 4, 2],
         'options' => \App\Models\ProductCategory::select(['id','name_ua'])->get()->prepend((object)['id' => '', 'name_ua' => '']),
         'optionName' => 'name_ua',
         ])

    @foreach(\App\Models\Datasets\Lang::all() as $lang)
        @include('widget.form.textarea', ['id' => 'name_'.$lang['id'], 'title' => 'Назва ('.$lang['id'].')', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
    @endforeach


    @include('widget.form.wide-card-image', ['id' => 'image', 'mdlCell' => [5, 8, 4],
        'showClearButton' => true,
    ])

        <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone footer">
            @include('widget.form.action-buttons', [
                'cancelUrl' => route('dashboard.product-category.index'),
           ])
        </div>
    </form>

    @if($model->id)
        <form id="destroy-form" action="{{ route('dashboard.product-category.destroy', [$model]) }}" method="GET" style="display: none;"> @csrf </form>
    @endif
@endsection
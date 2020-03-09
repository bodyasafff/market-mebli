@extends('dashboard.layouts.content')
@include('widget.form.push-resources')


@section('title') Продукти @endsection

@section('content')

    @include('widget.dialog-edit-image', ['isUpload' => false, 'isRemove' => false, 'minWidth' => '80%'])

    <form action="{{ route($model->id ? 'dashboard.product.update' : 'dashboard.product.store', [$model]) }}" method="post" enctype="multipart/form-data" class="mdl-grid">
        @csrf
        <input type="hidden" name="images_deleted" id="images_deleted_input" value="">
        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid">
            @include('widget.form.chosen-select-single', ['id' => 'product_category_id', 'title' => 'Категорії', 'mdlCell' => [3, 2, 4],
                 'options' => \App\Models\ProductCategory::select(['id','name_ua'])->get(),
                 'optionName' => 'name_ua',
                 'style' => 'height: 66px; padding-bottom: 0; margin-bottom: 0; float: right;',
            ])
            @include('widget.form.chosen-select-multiple', ['id' => 'properties', 'title' => 'Виберіть властивості', 'mdlCell' => [3, 2, 4],
                'options' =>  \App\Models\PropertyCategory::select(['id','name_ua'])->get(),
                'optionName' => 'name_ua',
                'cssClass' => 'search-choise-block',
                'group' => true,
            ])

            @include('widget.form.textarea', ['id' => 'price', 'title' => 'Ціна', 'mdlCell' => [3, 2, 4], 'maxlength' => 255])
            @if ($model->id)
                @include('widget.form.textarea', ['id' => 'notes', 'title' => 'Примітки', 'mdlCell' => [3, 4, 4], 'maxlength' => 255,'model' => $model->data_product])
                @else
                @include('widget.form.textarea', ['id' => 'notes', 'title' => 'Примітки', 'mdlCell' => [3, 4, 4], 'maxlength' => 255,])
            @endif

        </div>
        @foreach(\App\Models\Datasets\Lang::all() as $lang)
            <div class="mdl-cell mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone mdl-grid">
                @include('widget.form.textarea', ['id' => 'name_'.$lang['id'], 'title' => 'Назва ('.$lang['id'].')', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
                @if($model->id)
                   @include('widget.form.textarea', ['id' => 'description_'.$lang['id'], 'title' => 'Опис ('.$lang['id'].')', 'mdlCell' => [12, 8, 4], 'maxlength' => 255,'model' => $model->data_product])
                @else
                   @include('widget.form.textarea', ['id' => 'description_'.$lang['id'], 'title' => 'Опис ('.$lang['id'].')', 'mdlCell' => [12, 8, 4], 'maxlength' => 255])
                @endif
            </div>
        @endforeach

        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid">

                @include('widget.form.wide-card-image', ['id' => 'image', 'mdlCell' => [4, 8, 4],
                   'showClearButton' => true,
                ])


{{--           @for($j = 0;$j < App\Models\DataProduct::IMAGES_COUNT;$j++)--}}
{{--                @if($model->id)--}}
{{--                    @include('widget.form.wide-card-image', ['id' => 'images_'.$j , 'mdlCell' => [4, 8, 4],--}}
{{--                       'showClearButton' => true,--}}
{{--                       'src'=> !empty($model->data_product->images[$j]) ? asset('storage/'.$model->data_product->images[$j]) : asset('images/upload-image-default.png')--}}
{{--                    ])--}}
{{--                @else--}}
{{--                    @include('widget.form.wide-card-image', ['id' => 'images_'.$j , 'mdlCell' => [4, 8, 4],--}}
{{--                      'showClearButton' => true,--}}
{{--                    ])--}}
{{--                @endif--}}
{{--           @endfor--}}
        </div>

        @include('widget.form.images',['mdlCell' => [4, 8, 4],
        'id' => 'images'
        ])
        <div class="mdl-grid mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone footer">
            @include('widget.form.action-buttons', [
                'cancelUrl' => route('dashboard.product.index'),
           ])
        </div>


    </form>

    @if($model->id)
        <form id="destroy-form" action="{{ route('dashboard.product.destroy', [$model]) }}" method="GET" style="display: none;"> @csrf </form>
    @endif
@endsection
@push('js')

@endpush



{{--        @foreach($model->data_product->images as $i => $item)--}}
{{--        @include('widget.form.wide-card-photo', ['id' => 'image_origin_local_path_array', 'mdlCell' => [4, 8, 4],--}}
{{--            'showDeleteButton' => true,--}}
{{--            'src' => url('').'/storage/'.$item,--}}
{{--            'i' => $i,--}}
{{--        ])--}}
{{--        @endforeach--}}
@include('widget.form.push-resources')
<div class="pop-up-add-product-close-div" id="pop-up-add-product-close-div" >
    <button class="pop-up-add-product-close-div-unvisibilty" id="close-pop-up-btn">X</button>
</div>
<dialog id="pop-up-add-product" class="mdl-dialog" style="min-width: {{ isset($minWidth) ? $minWidth : '50%' }}; top: 60px;z-index: 11;max-height: 80vh">
    <form method="post" action="{{ route('dashboard.order.storeProduct') }}" class="mdl-grid">
        @csrf
        @include('widget.form.chosen-select-single', ['id' => 'product_category_id', 'title' => 'Категорії', 'mdlCell' => [12, 8, 4],
             'options' => \App\Models\ProductCategory::select(['id','name_ua'])->get()->prepend((object)['id' => '', 'name_ua' => '']),
             'optionName' => 'name_ua',
             'style' => 'height: 66px; padding-bottom: 0; margin-bottom: 0; float: right;',
        ])

        @include('widget.form.chosen-select-multiple', ['id' => 'properties', 'title' => 'Виберіть властивості', 'mdlCell' => [12, 8, 4],
            'options' =>  \App\Models\PropertyCategory::select(['id','name_ua'])->get(),
            'optionName' => 'name_ua',
            'cssClass' => 'search-choise-block',
            'group' => true,
            'model' => null
        ])

    @foreach(\App\Models\Datasets\Lang::all() as $lang)
        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid">
            @include('widget.form.textarea', ['id' => 'name_'.$lang['id'], 'title' => 'Назва ('.$lang['id'].')', 'mdlCell' => [6, 4, 4], 'maxlength' => 255])
            @include('widget.form.textarea', ['id' => 'description_'.$lang['id'], 'title' => 'Опис ('.$lang['id'].')', 'mdlCell' => [6, 4, 4], 'maxlength' => 255])
        </div>
    @endforeach
        @include('widget.form.textarea', ['id' => 'notes', 'title' => 'Примітки', 'mdlCell' => [12, 4, 4], 'maxlength' => 255])
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="width: 160px; background-color: #8bc34a!important;float: right">Створити</button>
    </form>
</dialog>

@push('js')
    <script>
        $("#pop-up-add-product-close-div").on('click',function () {
            document.getElementById("pop-up-add-product").open = false;
            $("#pop-up-add-product-close-div").attr('class','pop-up-order-detail-close-div-unvisibilty')
        })

    </script>
@endpush

@push('css')
    <style>
        .pop-up-add-product-close-div-visibilty{
            z-index: 10;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.5);
            position: absolute;
        }
        .close-pop-up-btn{
            color: #f3e5f5;
            float: right;
            margin-top: 20px;
            margin-right: 10%;
            padding: 10px 15px;
            font-size: 20px;
            background-color: rgba(0,0,0,0);
            border: solid 0px black;
        }
        .close-pop-up-btn:hover{
            background-color: rgba(0,0,0,0.6);
            transition: 0.3s;
        }
        .pop-up-add-product-close-div-unvisibilty{
            display: none;
        }
        .pagination{
            float: right;
        }
    </style>
@endpush
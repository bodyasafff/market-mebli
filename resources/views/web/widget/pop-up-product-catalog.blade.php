<div class="pop-up-product-catalog-close-div" id="pop-up-product-catalog-close-div" >
    <button class="pop-up-product-catalog-close-div-unvisibilty" id="close-pop-up-btn">X</button>
</div>
<dialog id="pop-up-product-catalog" class="product-catalog-dialog" style="min-width: {{ isset($minWidth) ? $minWidth : '50%' }}; top: 60px;z-index: 11;height: auto">
    <div class="parent_product_categories_div">
        <div class="parent_product_categories_div_head">{{trans('web.catalog_products')}}</div>
        @foreach($product_categories as $product_category)
            <div class="parent_product_categories_div_item">
               {{$product_category->name_ua}}
            </div>
        @endforeach
    </div>
    <div class="split_line"></div>
</dialog>

@push('js')
    <script>
        $("#pop-up-product-catalog-close-div").on('click',function () {
            document.getElementById("pop-up-product-catalog").open = false
            $("#pop-up-product-catalog-close-div").attr('class','pop-up-product-catalog-close-div-unvisibilty')
        })
    </script>
@endpush
@push('css')
    <style>
        .parent_product_categories_div{
            float: left;
            width: 20%;
            background-color: white;
        }
        .parent_product_categories_div_head{
            margin-top: 10px;
            font-weight: bold;
            font-size: 25px;
            text-align: center;
            padding-top: 15px;
        }
        .parent_product_categories_div_item{
            text-align: center;
            font-size: 20px;
            cursor: pointer;
            padding: 10px 0px;
        }
        .parent_product_categories_div_item:hover{
            background-color: #F67E7E;
        }

        .product-catalog-dialog{
            width: 98%;
            height: 100vh;
            margin-top: 30px;
            /*background-color: #aba69a;*/
            border: solid 0px white;
        }

        .split_line{
            float: left;
            width: 1px;
            background-color: gray;
            height: 20vh;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .pop-up-product-catalog-close-div-visibilty{
            z-index: 10;
            width: 100%;
            height: 100vh;
            background-color: rgba(0,0,0,0.2);
            position: absolute;
        }
        /*.close-pop-up-btn{*/
        /*    color: #d60e00;*/
        /*    float: right;*/
        /*    margin-top: 40px;*/
        /*    padding: 10px 15px;*/
        /*    font-size: 20px;*/
        /*    background-color: rgba(0,0,0,0);*/
        /*    border: solid 0px black;*/
        /*}*/
        .close-pop-up-btn:hover{
            background-color: rgba(0,0,0,0.6);
            transition: 0.3s;
        }
        .pop-up-product-catalog-close-div-unvisibilty{
            display: none;
        }
    </style>
@endpush
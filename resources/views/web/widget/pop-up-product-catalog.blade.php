<div class="pop-up-product-catalog-close-div" id="pop-up-product-catalog-close-div" onclick="closeModalWindowCatalog()">
</div>

<dialog id="pop-up-product-catalog" class="product-catalog-dialog">
    <div class="parent_product_categories_div">
        <div class="parent_product_categories_div_head">{{trans('web.catalog_products')}}</div>
        @foreach($product_categories as $product_category)
            <div class="parent_product_categories_div_item">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                    <path d="M0 0h24v24H0z" fill="none"/>
                </svg>
                {{$product_category->name_ua}}
                <div class="child_product_categories_div">
                    <div>stil
                        <div class="more_child_product_categories_div">
                            <div>stil</div>
                            <div>stil</div>
                            <div>stil</div>
                            <div>stil</div>
                        </div>
                    </div>
                    <div>taburet
                        <div class="more_child_product_categories_div">
                            <div>taburet</div>
                            <div>taburet</div>
                            <div>taburet</div>
                            <div>taburet</div>
                        </div>
                    </div>
                    <div>pol
                        <div class="more_child_product_categories_div">
                            <div>pol</div>
                            <div>pol</div>
                            <div>pol</div>
                            <div>pol</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="parent_product_categories_div_item">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
            {{$product_category->name_ua}}
        </div>
        <div class="parent_product_categories_div_item">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
            {{$product_category->name_ua}}
        </div>
        <div class="parent_product_categories_div_item">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
            {{$product_category->name_ua}}
        </div>
    </div>
</dialog>
@push('js')
    <script>
        function closeModalWindowCatalog() {
            document.getElementById("pop-up-product-catalog").open = false;
            $("#pop-up-product-catalog-close-div").attr('class', 'pop-up-product-catalog-close-div-unvisibilty');
            $('body').removeAttr('style');
        }
    </script>
@endpush
@push('css')
    <style>
        .parent_product_categories_div {
            float: left;
            width: 20%;
            background-color: white;
            margin: 25px 0;
            position: relative;
            border-right: solid 1px #555;
            box-sizing: initial;
        }

        .parent_product_categories_div_head {
            font-weight: bold;
            font-size: 25px;
            text-align: center;
            padding-bottom: 15px;
        }

        .parent_product_categories_div_item {
            text-align: center;
            font-size: 20px;
            cursor: pointer;
            padding: 10px 0px;
        }

        .parent_product_categories_div_item svg {
            width: 24px;
            float: left;
            margin-left: 15%;
        }


        .product-catalog-dialog{
            width: 98%;
            height: 100vh;
            margin-top: 30px;
            /*background-color: #aba69a;*/
            border: solid 0px white;

        .parent_product_categories_div_item:hover {
            background-color: #ffc6c1;

        }

        .product-catalog-dialog {
            width: calc(100% - 30px);
            min-height: 40vh;
            border: 0;
            z-index: 11;
        }


        .pop-up-product-catalog-close-div-visibilty {
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

            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            position: absolute;
        }

        .close-pop-up-btn {
            color: #d60e00;
            float: right;
            margin-top: 40px;
            margin-right: 11vw;
            padding: 10px 15px;
            font-size: 20px;
            background-color: rgba(0, 0, 0, 0);
            border: solid 0px black;
        }

        .close-pop-up-btn:hover {
            background-color: rgba(0, 0, 0, 0.6);
            transition: 0.3s;
        }

        .pop-up-product-catalog-close-div-unvisibilty {
            display: none;
        }

        .child_product_categories_div {
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
            min-height: 100%;
            text-align: center;
            font-size: 20px;
            cursor: pointer;
            border-right: solid 1px #555;
            display: none;
            box-sizing: initial;
            transform: translateX(calc(100% + 1px));

            transition: 0.3s;
        }

        .child_product_categories_div > div:first-of-type ,.more_child_product_categories_div > div:first-of-type{
            margin-top: 52px;
        }

        .child_product_categories_div > div {

            font-size: 20px;
            cursor: pointer;
            padding: 10px 0;
        }

        .child_product_categories_div > div:hover {
            background-color: #ffc6c1;
        }

        .parent_product_categories_div_item:hover > .child_product_categories_div {
            display: block;
        }

        .more_child_product_categories_div {
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
            min-height: 100%;
            text-align: center;
            font-size: 20px;
            cursor: pointer;
            border-right: solid 1px #555;
            display: none;
            box-sizing: initial;
            transform: translateX(calc(100% + 1px));
            transition: 0.3s;
        }

        .child_product_categories_div > div:hover .more_child_product_categories_div {
            display: block;
        }

    </style>
@endpush
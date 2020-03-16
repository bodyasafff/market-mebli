<div class="pop-up-basket-close-div" id="pop-up-basket-close-div" >
</div>
<dialog id="pop-up-basket" class="basket-dialog" style="min-width: {{ isset($minWidth) ? $minWidth : '50%' }}; top: 60px;z-index: 11;height: auto">
    <h1 style="margin-left: 5%;margin-top: 20px">{{trans('web.basket')}}</h1>
    <table style="width: 90%;margin-left: 5%">
        <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody class="basket-list-products" id="basket-list-products">

        </tbody>
    </table>
    <button class="basket-buy-button">{{trans('web.buy')}}</button>
</dialog>

@push('js')
    <script>
        $.ajax({
            url: '{{ url('') }}' + '/basket/' + localStorage.getItem('basketProducts') + '/index',
            type: "GET",
            success: function (data) {
                var basketProducts = JSON.parse(data);
                console.log(basketProducts);
                for(let i = 0;i < basketProducts.length;i++) {
                    $("#basket-list-products").append($('<tr>').attr('class','basket-products-item').attr('id','basket-products-item_'+basketProducts[i].id)
                        .append($('<th>').attr('class','th-basket-products-checkbox').append($('<input>').attr('type','checkbox').attr('class','basket-products-checkbox')))
                        .append($('<th>').attr('class','th-delete-product-from-basket').append($('<div>').attr('onclick','deleteProductFromBasket('+basketProducts[i].id+')').attr('class','delete-product-from-basket').attr('id','delete-basket_'+basketProducts[i].id).append('x')))
                        .append($('<th>').attr('class','th-basket-product-image').append($('<img>').attr('class','basket-product-image').attr('src','{{url('')}}/storage/'+basketProducts[i].image).attr('class','basket-product-image')))
                        .append($('<th>').attr('class','th-basket-product-name').append($('<div>').attr('class','basket-product-name').append(basketProducts[i].name_{{$_COOKIE['language']}})))
                        .append($('<th>').attr('class','th-basket-product-count').append($('<input>').attr('type','number').attr('class','basket-product-count-input')))
                        .append($('<th>').attr('class','th-basket-product-price').append($('<div>').attr('class','basket-product-price').append(basketProducts[i].price+" &#8372;")))
                    )
                }
            },
            error: function (error) {
                console.log(error);
            }
        })


        $("#pop-up-basket-close-div").on('click',function () {
            document.getElementById("pop-up-basket").open = false
            $("#pop-up-basket-close-div").attr('class','pop-up-basket-close-div-unvisibilty')
        })

        function deleteProductFromBasket(id) {
            var temp = localStorage.getItem('basketProducts');
            if(temp) {
                temp = temp.split(',');
                for (let i = 0; i < temp.length; i++) {
                    if (temp[i] == id) {
                        temp.splice(i,1);
                    }
                }
                temp = temp.join(',');
                localStorage.setItem('basketProducts',temp);
            }
            $("#basket-products-item_"+id).remove();
        }
    </script>
@endpush
@push('css')
    <style>
        .basket-dialog{
            width: 70%;
            margin-left: 15%;
            border: solid 0px white;
        }
        .pop-up-basket-close-div-visibilty{
            z-index: 10;
            width: 100%;
            height: 100vh;
            background-color: rgba(0,0,0,0.2);
            position: absolute;
        }
        .pop-up-basket-close-div-unvisibilty{
            display: none;
        }
        .basket-list-products{

        }

        .basket-products-item{
            display: flex;
            align-content: center;
            padding-top: 20px;
            padding-bottom: 20px;
            border-top: solid 1px gray;
        }

        .th-basket-products-checkbox{
            width: 40px;
        }
        .basket-products-checkbox{
            margin-top: 100%;
            margin-left: 20px;
        }

        .th-delete-product-from-basket{
            width: 40px;
        }
        .delete-product-from-basket{
            margin-top: 45%;
            margin-left: 20px;
            cursor: pointer;
            font-size: 30px;
            color: gray;
        }

        .th-basket-product-image{
            width: 200px;
        }
        .basket-product-image{
            width: 150px;
            margin-left: 30px;
        }

        .th-basket-product-name{
            width: 40%;
        }
        .basket-product-name{
            margin-left: 20px;
        }


        .th-basket-product-count{
            width: 50%;
        }
        .basket-product-count {
            margin-left: 20px;
        }
        .basket-product-count-input{
            border: solid 1px gray;
            padding-left: 10px;
        }

        .th-basket-product-price{
            width: 50%;
        }
        .basket-product-price{
            margin-left: 20px;
        }

        .basket-buy-button{
            float: right;
            margin-right: 30px;
            margin-bottom: 25px;
            color: white;
            font-weight: bold;
            background-color: #a32b22;
            padding: 10px 15px;
            border: solid 1px #a32b22;
        }
        .basket-buy-button:hover{
            background-color: white;
            color: #a32b22;
            transition: 0.3s;
        }
    </style>
@endpush
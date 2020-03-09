<div class="pop-up-order-detail-close-div" id="pop-up-order-detail-close-div" >
    <button class="pop-up-order-detail-close-div-unvisibilty" id="close-pop-up-btn">X</button>
</div>
    <dialog id="pop-up-order-detail" class="mdl-dialog" style="min-width: {{ isset($minWidth) ? $minWidth : '50%' }}; top: 60px;z-index: 11;max-height: 80vh">

            <div style="height: 80vh;overflow-y: auto;float: left;">
                <table class="mdl-data-table mdl-js-data-table" >
                        <tr><td >Номер:</td><td id="order_id"></td></tr>
                        <tr><td>Дата створення:</td><td id="order_created_at"></td></tr>
                        <tr><td>Підрозділ створення:</td><td id="order_creation_unit"></td></tr>
                        <tr><td>Стан:</td><td id="order_state"></td></tr>
                        <tr><td>Ціна виробника:</td><td id="order_price_producer"></td></tr>
                        <tr><td>Ціна зміни:</td><td id="order_price_change"></td></tr>
                        <tr><td>Місце перебування:</td><td id="order_product_location"></td></tr>
                        <tr><td>Спосіб оплати:</td><td id="order_payment_method"></td></tr>
                        <tr><td>Cтатус проплати:</td><td id="order_payment_status"></td></tr>
                        <tr><td>Дата проплати:</td><td id="order_date_payment"></td></tr>
                        <tr><td>Документ про проплату:</td><td id="order_payment_document"></td></tr>
                        <tr><td>Перевізник:</td><td id="order_delivery"></td></tr>
                        <tr><td>Дата відправлення:</td><td id="order_date_departure"></td></tr>
                        <tr><td>Дата прибуття:</td><td id="order_date_arrival"></td></tr>
                        <tr><td>Статус перевізника:</td><td id="order_delivery_status"></td></tr>
                        <tr><td>Статус клієнта:</td><td id="order_client_status"></td></tr>
                        <tr><td>Підрозділ повернення:</td><td id="order_return_location"></td></tr>
                        <tr><td>Статус замовлення:</td><td id="order_status"></td></tr>
                </table>
            </div>
            <div style="height: 80vh;overflow-y: auto;float: right;">
                <table id="data-table-pop-up" class="mdl-data-table mdl-js-data-table" style="margin-top: -48px;width: 60%">
                    <thead>
                    <tr>
                        <th style="width: 1px">id</th>
                        <th style="width: 1px"></th>
                        <th>Назва</th>
                        <th style="width: 1px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
        </div>
    </dialog>



@push('js')
    <script>
        $("#pop-up-order-detail-close-div").on('click',function () {
            document.getElementById("pop-up-order-detail").open = false
            $("#pop-up-order-detail-close-div").attr('class','pop-up-order-detail-close-div-unvisibilty')
        })

    </script>
@endpush
@push('css')
    <style>
        .pop-up-order-detail-close-div-visibilty{
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
        .pop-up-order-detail-close-div-unvisibilty{
           display: none;
        }
        .pagination{
            float: right;
        }
    </style>
@endpush
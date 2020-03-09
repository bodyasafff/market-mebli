@include('widget.form.push-resources')
<div class="pop-up-add-product-close-div" id="pop-up-add-client-close-div" >
    <button class="pop-up-add-product-close-div-unvisibilty" id="close-pop-up-btn-client">X</button>
</div>
<dialog id="pop-up-add-client" class="mdl-dialog" style="min-width: {{ isset($minWidth) ? $minWidth : '50%' }}; top: 60px;z-index: 11;max-height: 80vh">
    <form method="post" action="{{ route('dashboard.order.storeClient') }}" class="mdl-grid">
        @csrf
        @include('widget.form.textarea', ['id' => 'name', 'title' => 'Імя', 'mdlCell' => [12, 6, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'surname', 'title' => 'Прізвище', 'mdlCell' => [12, 4, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'middle_name', 'title' => 'По батькові', 'mdlCell' => [12, 6, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'country', 'title' => 'Країна', 'mdlCell' => [12, 4, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'city', 'title' => 'Місто', 'mdlCell' => [12, 4, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'street', 'title' => 'Вулиця', 'mdlCell' => [12, 4, 4], 'maxlength' => 255])
        @include('widget.form.textarea', ['id' => 'house', 'title' => 'Будинок', 'mdlCell' => [12, 4, 4], 'maxlength' => 255])

        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="width: 160px; background-color: #8bc34a!important;float: right">Створити</button>
    </form>
</dialog>

@push('js')
    <script>
        $("#pop-up-add-client-close-div").on('click',function () {
            document.getElementById("pop-up-add-client").open = false;
            $("#pop-up-add-client-close-div").attr('class','pop-up-order-detail-close-div-unvisibilty')
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
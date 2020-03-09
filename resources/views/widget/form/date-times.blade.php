
    <div class="mdl-cell mdl-cell--3-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid div-date-first">
        <label class="label-date">Дата оплати</label>
        <input class="input-date" type="datetime-local" id="date-payment" name="date_payment"  value="{{$model->date_payment? str_replace(' ','T',$model->date_payment) : null}}">
    </div>
    <div class="mdl-cell mdl-cell--3-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid div-date">
        <label class="label-date">Дата відправлення</label>
        <input class="input-date" type="datetime-local" id="date-departure" name="date_departure"  value="{{$model->date_departure? str_replace(' ','T',$model->date_departure) : null}}">
    </div>
    <div class="mdl-cell mdl-cell--3-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid div-date">
        <label class="label-date">Дата прибуття</label>
        <input class="input-date" type="datetime-local" id="date-arrival" name="date_arrival"  value="{{$model->date_arrival? str_replace(' ','T',$model->date_arrival) : null}}">
    </div>
    <div class="mdl-cell mdl-cell--3-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid div-date"></div>
    @push('css')
        <style>
           .label-date{
               text-align: center;
               border: solid 1px black;
               margin: 0!important;
               background-color:rgb(255,193,7);
               width: 100%;
               height: 30px;
               padding-top: 10px;
           }
           .input-date{
               margin: 0!important;
               width: 100%;
               height: 60px;
            }
           .div-date-first{
               margin: 0;
               padding: 0;
               margin-left: 2%;
               margin-top: 15px;
           }
           .div-date{
               margin: 0;
               padding: 0;
               margin-top: 15px;
           }
        </style>
    @endpush
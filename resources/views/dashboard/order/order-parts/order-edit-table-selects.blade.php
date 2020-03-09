<div class="mdl-cell mdl-cell--12-col main-tabel-selects-div" style="margin-top: 25px">

    <label class="mdl-cell mdl-cell--3-col  mdl-cell--2-col-tablet mdl-cell--4-col-phone tabel-selects-label">Клієнт</label>
    <div class="tabel-selects-div">

        @include('widget.form.chosen-select-single', ['id' => 'client_id', 'title' => '', 'mdlCell' => [8, 5, 4],
          'options' => \App\Models\Client::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
          'optionName' => 'name',
          'style' => 'height: 66px; padding: 0;margin:0; margin-top: 0!important;font-size:20px;',
        ])
        <button style="font-size: 15px; padding: 4px 10px;cursor: pointer" type="button" id="order-edit-add-client">Новий клієнт</button>
    </div>

    <label class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone tabel-selects-label">Перевізник</label>
    <div class="tabel-selects-div">

        @include('widget.form.chosen-select-single', ['id' => 'delivery_id', 'title' => '', 'mdlCell' => [9, 6, 4],
      'options' => \App\Models\Orders\Delivery::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
      'optionName' => 'name',
      'style' => 'height: 66px; padding: 0;margin:0; margin-top: 0!important;font-size:20px;'
    ])

    </div>

    <label class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone tabel-selects-label">Статус перевізника</label>
    <div class="tabel-selects-div">

        @include('widget.form.chosen-select-single', ['id' => 'delivery_status_id', 'title' => '', 'mdlCell' => [9, 6, 4],
          'options' => \App\Models\Orders\DeliveryStatus::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
          'optionName' => 'name',
          'style' => 'height: 66px; padding: 0;margin:0; margin-top: 0!important;font-size:20px;',
        ])

    </div>

    <label class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone tabel-selects-label">Статус клієнта</label>
    <div class="tabel-selects-div">

        @include('widget.form.chosen-select-single', ['id' => 'client_status_id', 'title' => '', 'mdlCell' => [9, 6, 4],
          'options' => \App\Models\Orders\ClientStatus::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
          'optionName' => 'name',
          'style' => 'height: 66px; padding: 0;margin:0; margin-top: 0!important;font-size:20px;',
         ])

    </div>

    <label class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone tabel-selects-label">Підрозділ повернення</label>
    <div class="tabel-selects-div">

        @include('widget.form.chosen-select-single', ['id' => 'return_location_id', 'title' => '', 'mdlCell' => [9, 6, 4],
          'options' => \App\Models\Orders\ReturnLocation::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
          'optionName' => 'name',
          'style' => 'height: 66px; padding: 0;margin:0; margin-top: 0!important;font-size:20px;',
        ])

    </div>

    <label class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone tabel-selects-label">Статус замолення</label>
    <div class="tabel-selects-div">

        @include('widget.form.chosen-select-single', ['id' => 'order_status_id', 'title' => '', 'mdlCell' => [9, 6, 4],
          'options' => \App\Models\Orders\OrderStatus::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
          'optionName' => 'name',
          'style' => 'height: 66px; padding: 0;margin:0; margin-top: 0!important;font-size:20px;',
        ])

    </div>
</div>
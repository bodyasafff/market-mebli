<div class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone select-div-first">
    <div class="select-label-div">
        <label style="margin-top: 50px">Підрозділ створення</label>
    </div>
    @include('widget.form.chosen-select-single', ['id' => 'creation_unit_id', 'title' => '', 'mdlCell' => [12, 8, 4],
        'options' => \App\Models\Orders\CreationUnit::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
        'optionName' => 'name',
        'style' => 'margin-bottom: 0;margin-top: 0!important;',
    ])
</div>

<div class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone select-div">
    <div class="select-label-div">
        <label style="margin-top: 50px">Місце перебування</label>
    </div>
    @include('widget.form.chosen-select-single', ['id' => 'product_location_id', 'title' => '', 'mdlCell' => [12, 8, 4],
         'options' => \App\Models\Orders\ProductLocation::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
         'optionName' => 'name',
         'style' => 'padding :!important; margin-bottom: 0;margin-top: 0!important;',
    ])
</div>

<div class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone select-div">
    <div class="select-label-div">
        <label style="margin-top: 50px">Спосіб оплати</label>
    </div>
    @include('widget.form.chosen-select-single', ['id' => 'payment_method_id', 'title' => '', 'mdlCell' => [12, 8, 4],
      'options' => \App\Models\Orders\PaymentMethod::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
      'optionName' => 'name',
      'style' => 'padding :!important; margin-bottom: 0;margin-top: 0!important;',
    ])
</div>

<div class="mdl-cell mdl-cell--3-col mdl-cell--2-col-tablet mdl-cell--4-col-phone select-div">
    <div class="select-label-div">
        <label style="margin-top: 50px">Статус проплати</label>
    </div>
    @include('widget.form.chosen-select-single', ['id' => 'payment_status_id', 'title' => '', 'mdlCell' => [12, 8, 4],
          'options' => \App\Models\Orders\PaymentStatus::select(['id','name'])->get()->prepend((object)['id' => '', 'name' => '']),
          'optionName' => 'name',
          'style' => 'padding :!important; margin-bottom: 0;margin-top: 0!important;',
    ])
</div>
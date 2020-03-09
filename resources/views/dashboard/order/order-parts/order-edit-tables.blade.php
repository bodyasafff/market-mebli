<div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid">
    @include('widget.form.chosen-select-multiple', ['id' => 'properties', 'title' => 'Сортування', 'mdlCell' => [3, 4, 2],
       'options' =>  \App\Models\PropertyCategory::select(['id','name_ua'])->get(),
       'name' => 'properties_only-filter-select',
       'optionName' => 'name_ua',
       'cssClass' => 'search-choise-block',
       'group' => true,
       'model' => null
     ])

    @include('widget.form.chosen-select-multiple', ['id' => 'properties', 'title' => 'Виберіть властивості', 'mdlCell' => [3, 4, 2],
      'options' =>  \App\Models\PropertyCategory::select(['id','name_ua'])->get(),
      'name' => 'properties-filter-select',
      'optionName' => 'name_ua',
      'cssClass' => 'search-choise-block',
      'group' => true,
      'model' => null
    ])

    @include('widget.form.chosen-select-single', ['id' => 'product_category_id-filter-select', 'title' => 'Категорії', 'mdlCell' => [3, 4, 2],
             'options' => \App\Models\ProductCategory::select(['id','name_ua'])->get()->prepend((object)['id' => '', 'name_ua' => '']),
             'optionName' => 'name_ua',
    ])
</div>
<div class="base-data-table mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
    <div style="width: 100%">
    <button id="order-edit-add-product" type="button" class="mdl-button mdl-js-button mdl-button--raised">
        Новий товар
    </button>
    </div>
    <table id="data-table" class="mdl-data-table mdl-js-data-table" style="width: 100%"></table>
</div>
<div class="base-data-table mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
    <table id="data-table-release" class="mdl-data-table mdl-js-data-table" style="width: 100%">
        <thead>
        <tr>
            <th style="width: 1px">id</th>
            <th style="width: 1px"></th>
            <th>Назва</th>
            <th style="width: 1px"></th>
            <th style="width: 1px"></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
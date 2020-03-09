<div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone mdl-grid" id="items-card-photos-div" style="padding: 0; margin: 0; width: 100%;">
    @if(!empty($model->data_product->{$id}))
        @foreach($model->data_product->{$id} as $i => $item)
            @include('widget.form.wide-card-image', ['id' => $id, 'mdlCell' => $mdlCell,
                'showDeleteButton' => true,
                'src' => url('').'/storage/'.$item,
                'i' => $i,
            ])
        @endforeach
    @endif

    <div id="add-new-items-form-btn"
         class="mdl-cell mdl-cell--{{ $mdlCell[0] }}-col mdl-cell--{{ $mdlCell[1] }}-col-tablet mdl-cell--{{ $mdlCell[2] }}-col-phone"
         style="background-color: rgba(0,0,0,.1); margin-top: 30px; position: relative;  min-height: 150px;">
        <div class="mdl-button mdl-js-button mdl-button--accent"
             style="position:absolute; height: 100%; width: 100%; padding: 0; margin: 0;"
             onclick="addNewItemsForm()">
            <span class="material-icons" style="font-size: 36px; color: #fff;">playlist_add</span>
        </div>
    </div>
</div>

<template id="add-new-card-photo-template">
    @include('widget.form.wide-card-image', ['id' => $id, 'mdlCell' => $mdlCell,
        'showDeleteButton' => true,
        'src' => asset('images/base/upload-image-default.png'),
        'i' => '${newItemI}',
    ])
</template>

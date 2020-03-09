<div class="wide-card-photo mdl-card {{ !empty($mdlCell) ? 'mdl-cell mdl-cell--'.$mdlCell[0].'-col mdl-cell--'.$mdlCell[1].'-col-tablet mdl-cell--'.$mdlCell[2].'-col-phone' : ''}}" style="min-height: 0;" id="{{ $id }}{{ isset($i) ? '_'.$i : '' }}_wide-card">
    @if(!empty($title))
        <div class="mdl-card__title" style="margin-top: -10px; margin-bottom: -28px; margin-left: 50px;">
            <h2 class="mdl-card__title-text {{ $errors->has($id) ? 'is-invalid' : '' }}" style="font-size: 11px; font-weight: 400;">{{ $title }}</h2>
        </div>
    @endif

    <div class="mdl-card__supporting-text mdl-grid" style="padding: 0; width: auto;">
        <div style="width: 100%;">
            @if(isset($showDeleteButton) || isset($showClearButton))
                <span class="mdl-button mdl-js-button mdl-button--accent" onclick="wideCardDeleteImage('{{ $id }}{{ isset($i) ? '_'.$i : '' }}', {{ !empty($showClearButton) ? 'true' : 'false' }})" style="float: right; min-width: 16px;">
                    <i class="material-icons" style="margin-top: 6px;">{{ !empty($showClearButton) ? 'delete' : 'clear' }}</i>
                </span>
            @endif
            <label for="{{ $id }}{{ isset($i) ? '_'.$i : '' }}">
                <span class="mdl-button mdl-js-button" style="float: left; min-width: 16px;">
                    <i class="material-icons" style="margin-top: 6px;">save_alt</i>
                </span>
            </label>
        </div>

        @include('widget.form.error-validation-simple')
        <div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone">
            <img class="base-img-fit-contain"
                 src="{{ !empty($src) ? $src : ($model->{$id} ? url('').'/storage/'.$model->{$id} : asset('images/base/upload-image-default.png') )}}"
                 onerror="this.src='{{ asset('images/base/upload-image-default.png') }}'"
                 style="cursor: pointer; {{ !empty($imgStyle) ? $imgStyle : '' }}"
                 id="{{ $id }}{{ isset($i) ? '_'.$i : '' }}_img"
                 onclick="showDialogEditImage(this, true)"
            />
        </div>
        <input type="file" accept="image/*" name="{{ $id }}{{ isset($i) ? '['.$i.']' : '' }}" id="{{ $id }}{{ isset($i) ? '_'.$i : '' }}" class="invisible" onchange="wideCardDeleteImage('{{ $id }}{{ isset($i) ? '_'.$i : '' }}', true); showPhotoPreview(this)" value="">
    </div>
</div>



<div class="wide-card-image mdl-card {{ !empty($mdlCell) ? 'mdl-cell mdl-cell--'.$mdlCell[0].'-col mdl-cell--'.$mdlCell[1].'-col-tablet mdl-cell--'.$mdlCell[2].'-col-phone' : ''}}">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text {{ $errors->has($id) ? 'is-invalid' : '' }}">{{ $title }}</h2>
    </div>

    <div class="mdl-card__supporting-text mdl-grid">
        @include('widget.form.error-validation-simple')
        <label class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone" for="{{ $id }}">
            @if(isset($showUploadButton) && $showUploadButton)
                <div style="text-align: center; padding-bottom: 20px;">
                    <div class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Choose file</div>
                </div>
            @endif
            <img style="display: none;" class="base-img-fit-contain" src="{{ !isset($mediaType) || $mediaType == 'video' ? asset('images/upload-video-default.png') : asset('images/upload-audio-default.png') }}" />
            <{{ !isset($mediaType) || $mediaType == 'video' ? 'video' : 'audio' }} src="{{ isset($model->id) ? $model->{$id} : '' }}" class="base-img-fit-contain audio-preview" controls onerror="this.parentElement.getElementsByTagName('img')[0].style.display = 'block'; this.style.display = 'none';"></{{ !isset($mediaType) || $mediaType == 'video' ? 'video' : 'audio' }}>
        </label>
        <input type="file" accept="{{ !isset($mediaType) ? 'audio/mp3, video/mp4' : ($mediaType == 'video' ? 'video/mp4' : 'audio/mp3') }}" name="{{ $id }}" id="{{ $id }}" class="invisible" onchange="showMediaPreview(this)" value="">
    </div>
</div>




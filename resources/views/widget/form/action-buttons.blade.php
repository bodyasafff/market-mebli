<div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone action-buttons-div {{ !$model->id ? 'center' : '' }}">
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="{{ isset($createButtonText) && !$model->id ? 'width: 160px;' : 'width: 120px;' }} background-color: #8bc34a">{{ $model->id ? 'Зберегти' : (isset($createButtonText) ? $createButtonText : 'Створити') }}</button>
    @if($cancelUrl)
        <a href="{{ $cancelUrl }}" class="mdl-button mdl-js-button" style="margin-left: 20px;">Назад</a>
    @endif
    @if($model->id)
        <a class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" style="float: right;" href="#" onclick="event.preventDefault(); if (confirm('Видалити?')) {document.getElementById('destroy-form').submit();}">Видалити</a>
    @endif
</div>
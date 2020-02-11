<div class="mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--4-col-phone uppercase-all time-log">
    <div>Created: {{ \Carbon\Carbon::parse($model->created_at)->format('d M Y H:i') }} UTC</div>
    @if($model->created_at != $model->updated_at)
        <div>Updated: {{ \Carbon\Carbon::parse($model->updated_at)->format('d M Y H:i') }} UTC</div>
    @endif
</div>
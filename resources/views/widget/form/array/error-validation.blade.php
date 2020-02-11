@if ($errors->has($arrayName.'.'.$i.'.'.$id))
    <span class="mdl-textfield__error">{{ $errors->first($arrayName.'.'.$i.'.'.$id) }}</span>
@endif
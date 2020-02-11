@extends('layouts.dashboard.content')
@include('widget.form.push-resources')

@section('head_title') {{ config('app.name') }} @endsection
@section('title') Продукти @endsection

@section('content')
    @foreach(\App\Models\Datasets\ProcessList::where(['group', '=', 1]) as $process)
        @if(is_numeric($process->id) && \App\Models\Datasets\ProcessList::checkEnv($process->id))
            <a href="{{ route('dashboard.console-proc.index', [$process->id, 1]) }}" class="mdl-navigation__link">{{ $process->name }}</a>
        @endif
    @endforeach
    <hr>
    @foreach(\App\Models\Datasets\ProcessList::where(['group', '=', 2]) as $process)
        @if(is_numeric($process->id) && \App\Models\Datasets\ProcessList::checkEnv($process->id))
            <a href="{{ route('dashboard.console-proc.index', [$process->id, 1]) }}" class="mdl-navigation__link">{{ $process->name }}</a>
        @endif
    @endforeach
    <hr>
    @foreach(\App\Models\Datasets\ProcessList::where(['group', '=', 3]) as $process)
        @if(is_numeric($process->id) && \App\Models\Datasets\ProcessList::checkEnv($process->id))
            <a href="{{ route('dashboard.console-proc.index', [$process->id, 1]) }}" class="mdl-navigation__link">{{ $process->name }}</a>
        @endif
    @endforeach
@endsection

@push('css')

@endpush

@push('js')

@endpush
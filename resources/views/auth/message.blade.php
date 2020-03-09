@extends('dashboard.dashboard.app')

@push('css')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/base/content.css')}}">
@endpush

@section('main')
<body class="mdl-js">

<div class="mdl-layout__container">
    <div class="mdl-layout mdl-js-layout mdl-color--grey-100">
        <main class="mdl-layout__content">
            <div class="mdl-card mdl-shadow--6dp">
                <div class="mdl-card__title mdl-color--primary mdl-color-text--white {{ !isset($status) || $status ? 'btn-green' : 'btn-red' }}">
                    <h2 class="mdl-card__title-text">{{ config('app.name', 'Laravel') }}</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <h3 class="{{ !isset($status) || $status ? 'color-green' : 'color-red' }}" style="font-size: 18px; text-align: center;">{{ $message }}</h3>
                </div>
            </div>
        </main>
    </div>
</div>

@endsection

@push('js')
    <script>
        $(function () {
            localStorage.clear();
            sessionStorage.clear();
        });
    </script>
@endpush
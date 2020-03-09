@extends('dashboard.layouts.app')

@push('css')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endpush

@section('main')
<body class="mdl-js">

<div class="mdl-layout__container">
    <div class="mdl-layout mdl-js-layout mdl-color--grey-100">
        <main class="mdl-layout__content">
            <div class="mdl-card mdl-shadow--6dp">
                <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                    <h2 class="mdl-card__title-text">{{ config('app.name', 'Laravel') }}</h2>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mdl-card__supporting-text">
                        @include('widget.form.text-input', ['id' => 'email', 'title' => 'E-Mail Address',
                            'typeInput' => 'email',
                            'inputAttr' => 'required autofocus'
                        ])
                        @include('widget.form.text-input', ['id' => 'password', 'title' => 'Password',
                            'typeInput' => 'password',
                            'inputAttr' => 'required'
                        ])
                    </div>
                    <div class="mdl-card__actions mdl-card--border" style="border-top: 0; padding-top: 0;">
                        <button class="mdl-button mdl-button--colored mdl-js-button">Log in</button>
                    </div>
                </form>
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
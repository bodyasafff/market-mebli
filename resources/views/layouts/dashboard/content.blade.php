@extends('layouts.dashboard.app')

@section('main')

    <body class="mdl-js">

    <div id="app-layout" class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-drawer">
        <header class="mdl-layout__header header-shadow mdl-layout__header--waterfall">
            <div class="mdl-layout__header-row">
                <span class="mdl-layout-title">
                    @yield('title')
                </span>
                <a href="{{ route('dashboard.index') }}" class="mdl-navigation__link"></a>
                <div class="mdl-layout-spacer"></div>
                <nav class="mdl-navigation">
                    @guest
                        <a class="mdl-navigation__link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        <a class="mdl-navigation__link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @else
                        @yield('global-search-input')
                    @endguest
                </nav>
            </div>
            @yield('tab-bar')
        </header>
        @auth
            <div class="mdl-layout__drawer mdl-js-layout__drawer" id="main-right-side-menu" style="display: none;">
                <span class="mdl-layout-title">MarketMebli</span>
                <nav class="mdl-navigation mdl-layout-spacer">
                    @if(\App\Models\User::hasRole(\App\Models\Datasets\UserRole::ADMIN))
{{--                        <a href="{{ route('dashboard.index') }}" class="mdl-navigation__link">Dashboard</a>--}}
                        <a href="{{ route('dashboard.product-category.index') }}" class="mdl-navigation__link">Категорії продуктів</a>
                        <hr>
                    @endif
                    <div class="mdl-layout-spacer"></div>
                    <a class="mdl-navigation__link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </nav>
            </div>
        @endauth
        <main class="mdl-layout__content hide-scroll">
            <div id="page-content" class="page-content">
                @yield('content')
{{--                @include('widget.snackbar')--}}
            </div>
        </main>
    </div>

@endsection


@push('js')
    <script>
        var dataTable;
        var tempDataTable = {};

        var baseAdminImageUrl = '{{ url('').'/storage/' }}';
        var defaultImageUrl = '{{ asset('images/base/upload-image-default.png') }}';
        var storageUrl = '{{ asset('storage') }}';
        var pathImage = '{{ asset('storage').'/' }}';
        var baseAdminUrl = '{{ config('app.url').'/dashboard/' }}';
        var userLanguageId = '{{ app()->getLocale() }}';
        var expandAllFlag = 0;

        mdl(function(){
            @if(session()->has('scrollBottom'))
                setTimeout(function () {
                    $('.mdl-layout__content').animate({scrollTop: 99999}, 200);
                }, 1);
            @endif

            setTimeout(function () {
                @if(session()->has('snackbar'))
                    showSnackbarDefault('{{ session()->get('snackbar') }}', '{{ session()->get('actionBackUrl') }}');
                @elseif(!empty($errors) && count($errors) > 0)
                    showSnackbarDefault(false);
                    if($('.is-invalid').length){
                        $('.mdl-layout__content').first().animate({scrollTop: $('.is-invalid').offset().top - 200}, 200);
                    }
                @endif
            }, 1);
        });
    </script>
    <script src="{{ asset('js/base/dashboard.js') }}"></script>
@endpush
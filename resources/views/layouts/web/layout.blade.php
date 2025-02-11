@extends('layouts.web.app')
@php

    if(isset($_COOKIE['language'])){
   App::setLocale($_COOKIE['language']);
   }
else{
   $_COOKIE['language'] = 'ua';
   }
@endphp
@section('layout')
    <body>
    <header>
        <div class="header-info">
            <div class="header-info-link">
                <a href="#">Доставка</a>
                <a href="#">Оплата</a>
                <a href="#">Отзывы</a>
                <a href="#">Вопрос-ответ</a>
                <a href="#">Контакты</a>
            </div>
            <div class="header-info-phone">
                <p>Тел:
                    <span>8 (812) 123-45-67</span>
                    <span>8 (812) 123-45-67</span>
                </p>
            </div>
        </div>
        <div class="header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 87.34 74.02">
                <defs>
                    <style>.cls-1, .cls-2, .cls-3, .cls-4, .cls-6 {
                            fill: #fff;
                        }

                        .cls-2 {
                            font-size: 7px;
                        }

                        .cls-2, .cls-3, .cls-4, .cls-6 {
                            font-family: Arial-BoldItalicMT, Arial;
                            font-weight: 700;
                            font-style: italic;
                        }

                        .cls-3 {
                            font-size: 10px;
                            letter-spacing: -0.03em;
                        }

                        .cls-4 {
                            font-size: 14px;
                        }

                        .cls-5 {
                            letter-spacing: 0.01em;
                        }

                        .cls-6 {
                            font-size: 6px;
                            letter-spacing: -0.07em;
                        }

                        .cls-7 {
                            letter-spacing: -0.12em;
                        }

                        .cls-8 {
                            letter-spacing: -0.11em;
                        }</style>
                </defs>
                <title>Ресурс 2</title>
                <g id="Слой_2" data-name="Слой 2">
                    <g id="Слой_2-2" data-name="Слой 2">
                        <path class="cls-1"
                              d="M62.5,9.13l-29,28.75S22.63,22,10.38,18.5L32,49.63l5.88-4.75L36.13,55.63l-10.63.12s-8.83-2.87-12-21.87C12.13,25.63,0,12.25,0,12.25l22.5.13L33.88,25.13Z"/>
                        <path class="cls-1"
                              d="M27.38,10l7.5,8A46.89,46.89,0,0,1,73.63,6.25L40.88,42.75,36.5,68s9.63-32,47-66C83.5,2,58.25-6,27.38,10Z"/>
                        <text class="cls-2" transform="translate(4.25 62.75)">МЕРЕЖА</text>
                        <text class="cls-3" transform="translate(46.62 55.25)">МАРКЕТ</text>
                        <text class="cls-4" transform="translate(38 68.75)">МЕ
                            <tspan class="cls-5" x="21" y="0">Б</tspan>
                            <tspan x="31.08" y="0">ЛІ</tspan>
                        </text>
                        <text class="cls-6" transform="translate(2.75 68.75)">МА
                            <tspan class="cls-7" x="8.49" y="0">Г</tspan>
                            <tspan class="cls-8" x="11.45" y="0">А</tspan>
                            <tspan x="15.13" y="0">ЗИНІВ</tspan>
                        </text>
                    </g>
                </g>
            </svg>
            <h5>Маркет<br/>меблі</h5>
            <input class="header-search">
            <div class="header-svg-icons">
                <div>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 0C14.4399 0 10.9598 1.05568 7.99974 3.03355C5.03966 5.01141 2.73255 7.82263 1.37018 11.1117C0.00779911 14.4008 -0.348661 18.02 0.345873 21.5116C1.04041 25.0033 2.75474 28.2106 5.27208 30.7279C7.78943 33.2453 10.9967 34.9596 14.4884 35.6541C17.98 36.3487 21.5992 35.9922 24.8883 34.6298C28.1774 33.2674 30.9886 30.9603 32.9664 28.0003C34.9443 25.0402 36 21.5601 36 18C36 15.6362 35.5344 13.2956 34.6298 11.1117C33.7252 8.92783 32.3994 6.94353 30.7279 5.27208C29.0565 3.60062 27.0722 2.27475 24.8883 1.37017C22.7044 0.465584 20.3638 0 18 0ZM18 5.4C19.068 5.4 20.1121 5.7167 21.0001 6.31006C21.8881 6.90342 22.5802 7.74679 22.989 8.73351C23.3977 9.72023 23.5046 10.806 23.2962 11.8535C23.0879 12.901 22.5736 13.8632 21.8184 14.6184C21.0632 15.3736 20.101 15.8879 19.0535 16.0962C18.006 16.3046 16.9202 16.1977 15.9335 15.7889C14.9468 15.3802 14.1034 14.6881 13.5101 13.8001C12.9167 12.9121 12.6 11.868 12.6 10.8C12.6 9.36783 13.1689 7.99432 14.1816 6.98162C15.1943 5.96893 16.5678 5.4 18 5.4ZM18 30.96C15.8614 30.96 13.7559 30.4308 11.8715 29.4194C9.98708 28.4081 8.3822 26.9462 7.20001 25.164C7.25401 21.582 14.4 19.62 18 19.62C21.6 19.62 28.746 21.582 28.8 25.164C27.6178 26.9462 26.0129 28.4081 24.1285 29.4194C22.2441 30.4308 20.1387 30.96 18 30.96Z"
                              fill="white"/>
                    </svg>
                </div>
                <div>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.8 28.8C10.088 28.8 9.39196 29.0111 8.79995 29.4067C8.20793 29.8023 7.74651 30.3645 7.47403 31.0223C7.20156 31.6801 7.13027 32.404 7.26917 33.1023C7.40808 33.8007 7.75095 34.4421 8.25441 34.9456C8.75788 35.4491 9.39934 35.7919 10.0977 35.9308C10.796 36.0697 11.5198 35.9984 12.1777 35.726C12.8355 35.4535 13.3977 34.9921 13.7933 34.4001C14.1889 33.808 14.4 33.112 14.4 32.4C14.4 31.4452 14.0207 30.5295 13.3456 29.8544C12.6705 29.1793 11.7548 28.8 10.8 28.8ZM0 0V3.6H3.6L10.08 17.262L7.65 21.672C7.35223 22.199 7.19713 22.7947 7.2 23.4C7.20285 24.3539 7.58305 25.2679 8.25756 25.9424C8.93208 26.617 9.8461 26.9971 10.8 27H32.4V23.4H11.556C11.4968 23.4005 11.438 23.3892 11.3832 23.3667C11.3284 23.3443 11.2786 23.3111 11.2367 23.2693C11.1948 23.2274 11.1617 23.1776 11.1393 23.1228C11.1168 23.068 11.1055 23.0092 11.106 22.95L11.16 22.734L12.78 19.8H26.19C26.8331 19.802 27.4649 19.631 28.0191 19.3048C28.5734 18.9786 29.0296 18.5092 29.34 17.946L35.784 6.264C35.9289 5.9993 36.0033 5.70176 36 5.4C36 4.92261 35.8104 4.46477 35.4728 4.12721C35.1352 3.78964 34.6774 3.6 34.2 3.6H7.578L5.886 0H0ZM28.8 28.8C28.088 28.8 27.392 29.0111 26.7999 29.4067C26.2079 29.8023 25.7465 30.3645 25.474 31.0223C25.2016 31.6801 25.1303 32.404 25.2692 33.1023C25.4081 33.8007 25.7509 34.4421 26.2544 34.9456C26.7579 35.4491 27.3993 35.7919 28.0977 35.9308C28.796 36.0697 29.5198 35.9984 30.1777 35.726C30.8355 35.4535 31.3977 34.9921 31.7933 34.4001C32.1889 33.808 32.4 33.112 32.4 32.4C32.4 31.4452 32.0207 30.5295 31.3456 29.8544C30.6705 29.1793 29.7548 28.8 28.8 28.8Z"
                              fill="white"/>
                    </svg>

                </div>
                <div>
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.982 0C8.046 0 0 8.064 0 18C0 27.936 8.046 36 17.982 36C27.936 36 36 27.936 36 18C36 8.064 27.936 0 17.982 0ZM30.456 10.8H25.146C24.57 8.55 23.742 6.39 22.662 4.392C25.974 5.526 28.728 7.83 30.456 10.8ZM18 3.672C19.494 5.832 20.664 8.226 21.438 10.8H14.562C15.336 8.226 16.506 5.832 18 3.672ZM4.068 21.6C3.78 20.448 3.6 19.242 3.6 18C3.6 16.758 3.78 15.552 4.068 14.4H10.152C10.008 15.588 9.9 16.776 9.9 18C9.9 19.224 10.008 20.412 10.152 21.6H4.068ZM5.544 25.2H10.854C11.43 27.45 12.258 29.61 13.338 31.608C10.026 30.474 7.272 28.188 5.544 25.2ZM10.854 10.8H5.544C7.272 7.812 10.026 5.526 13.338 4.392C12.258 6.39 11.43 8.55 10.854 10.8ZM18 32.328C16.506 30.168 15.336 27.774 14.562 25.2H21.438C20.664 27.774 19.494 30.168 18 32.328ZM22.212 21.6H13.788C13.626 20.412 13.5 19.224 13.5 18C13.5 16.776 13.626 15.57 13.788 14.4H22.212C22.374 15.57 22.5 16.776 22.5 18C22.5 19.224 22.374 20.412 22.212 21.6ZM22.662 31.608C23.742 29.61 24.57 27.45 25.146 25.2H30.456C28.728 28.17 25.974 30.474 22.662 31.608ZM25.848 21.6C25.992 20.412 26.1 19.224 26.1 18C26.1 16.776 25.992 15.588 25.848 14.4H31.932C32.22 15.552 32.4 16.758 32.4 18C32.4 19.242 32.22 20.448 31.932 21.6H25.848Z"
                              fill="white"/>
                    </svg>
                </div>
            </div>
        </div>
    </header>

    @yield('content')


    @endsection



    @push('css_base')
        <script src="{{ asset('js/plugins/jquery-3.4.1.min.js') }}"></script>
    @endpush

    @push('js')
        <script>
            function transletePage(t) {
                document.cookie = 'language=' + t.innerHTML;
                location.reload();
            }

        </script>
    @endpush
    @push('css')
        <style>
            body {
                font-family: Arial;
            }

            .header-info {
                background: #E5E5E5;
                display: flow-root;
                width: -webkit-fill-available;
                padding: 10px 30px;
            }

            .header-info p {
                margin-bottom: 0;
            }

            .header-info-link {
                float: left;
            }

            .header-info-link a {
                font-style: normal;
                font-weight: normal;
                font-size: 14px;
                line-height: 16px;
                margin-left: 15px;
                color: #333333;
                text-decoration: none;
                outline: none;
            }

            .header-info-link a:hover {
                color: #4495E0;
            }

            .header-info-phone {
                float: right;
                color: #3B3B3B;
                font-weight: 500;
                font-size: 14px;
                line-height: 17px;
                margin-top: 3px;
            }

            .header-info-phone span {
                font-style: normal;
                font-weight: normal;
                font-size: 16px;
                line-height: 19px;
                color: #000000;
            }

            .header {
                background: linear-gradient(180deg, #1472D6 0%, #1B9EE0 100%);
                opacity: 0.8;
                padding: 10px 10%;
                display: flex;
                width: 100%;
                max-height: none;
            }

            .header > svg {
                width: 85px;
            }

            .header h5 {
                margin: 0;
                font-weight: 900;
                font-size: 28px;
                margin-left: 20px;
                line-height: 34px;
                color: #FFC531;
            }

            .header input {
                background: #EFEFEF;
                border-radius: 40px;
            }

            .header-search {
                align-self: center;
                /*348px= icon + "name" + "3 * svg(cart,account,lang)"*/
                width: calc(80% - 348px);
                margin: auto 10%;
                height: 40px;
            }

            .header-svg-icons {
                display: flex;
                align-items: center;
            }

            .header-svg-icons > div {
                margin-left: 15px;
            }

        </style>
    @endpush
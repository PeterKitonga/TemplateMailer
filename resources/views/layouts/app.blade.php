<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{!! asset('materialize/css/materialize.min.css') !!}" rel="stylesheet">
        <link href="{!! asset('themify-icons/css/themify-icons.css') !!}" rel="stylesheet">
        @stack('styles')
        <link href="{!! asset('css/custom.css') !!}" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = '{!! json_encode(['csrfToken' => csrf_token()]) !!}';
        </script>
    </head>
    <body>
        <nav class="red">
            <div class="nav-wrapper">
                <a href="{{ url('/') }}" class="brand-logo">{{ config('app.name', 'Laravel') }}</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="ti-menu"></i></a>
                <ul class="side-nav" id="mobile-demo">
                    @if (Auth::guest())
                        <li {!! Request::is('login') ? 'class="active"' : '' !!}><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li {!! Request::is('recipients*') ? 'class="active"' : '' !!}><a href="{{ url('/recipients') }}">Recipients</a></li>
                        <li {!! Request::is('templates*') ? 'class="active"' : '' !!}><a href="{{ url('/templates') }}">Templates</a></li>
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Logout">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
                <ul class="right hide-on-med-and-down">
                    @if (Auth::guest())
                        <li {!! Request::is('login') ? 'class="active"' : '' !!}><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li {!! Request::is('recipients*') ? 'class="active"' : '' !!}><a href="{{ url('/recipients') }}">Recipients</a></li>
                        <li {!! Request::is('templates*') ? 'class="active"' : '' !!}><a href="{{ url('/templates') }}">Templates</a></li>
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Logout">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>

                <ul id="user-dropdown" class="dropdown-content">

                </ul>
            </div>
        </nav>

        @yield('content')
        @include('partials.modals');

        <!-- Scripts -->
        <script src="{!! asset('js/jquery-3.1.0.min.js') !!}"></script>
        <script src="{!! asset('materialize/js/materialize.min.js') !!}"></script>
        <script>
            $(function () {
                var status = '{!! Request()->session()->get('status') !!}';

                if(status !== '')
                {
                    Materialize.toast(status, 10000);
                    {!! Request()->session()->forget('success') !!}
                }
            });
        </script>
        <script src="{!! asset('js/custom.js') !!}"></script>
        @stack('scripts')
    </body>
</html>

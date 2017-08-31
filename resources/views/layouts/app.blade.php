<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{!! asset('materialize/css/materialize.min.css') !!}" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = '{!! json_encode(['csrfToken' => csrf_token()]) !!}';
        </script>
    </head>
    <body>
        <ul id="user-dropdown" class="dropdown-content">
            <li>
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
        <nav>
            <div class="nav-wrapper">
                <a href="{{ url('/') }}" class="brand-logo">{{ config('app.name', 'Laravel') }}</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li>
                            <a class="dropdown-button" href="#" data-activates="user-dropdown">{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                    @endif
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        <li>
                            <a class="dropdown-button" href="#" data-activates="user-dropdown">{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        @yield('content')

        <!-- Scripts -->
        <script src="{!! asset('js/jquery-3.1.0.min.js') !!}"></script>
        <script src="{!! asset('materialize/js/materialize.min.js') !!}"></script>
    </body>
</html>

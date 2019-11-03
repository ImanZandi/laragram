<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laragram') }}</title>

    <!-- Scripts -->
{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

<!-- Fonts --> {{--
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    --}}

<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar mb-12">
        <div class="container">
            <div class="flex items-center justify-between">
                <a class="navbar__brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="laragram">
                </a>

                <div class="w-1/3">
                    <form action="/users/search" method="GET">
                        <div class="flex relative justify-center items-center">
                            <input
                                class="bg-gray-200 pl-12 pr-4 py-2 rounded w-full border focus:outline-none focus:border-indigo-500"
                                type="text"
                                name="q"
                                placeholder="Know anyone ...?">
                            <span class="absolute left-0 ml-4 text-gray-500">
                                <svg class="fill-current w-5 h-5"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24"
                                     width="24"
                                     height="24">
                                    <path class="heroicon-ui"
                                          d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/>
                                </svg>
                            </span>
                        </div>
                    </form>
                </div>

                <ul class="flex">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="flex nav-item">
                            <a id="navbarDropdown" class="mr-3" href="#" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="flex items-center" aria-labelledby="navbarDropdown">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

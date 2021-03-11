<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') . __(' | ') }}@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="user">
    <div id="app">
        <div id="wrapper" class="wrapper d-flex">
            <div class="bg-light border-right sidebar-wrapper">
                <div class="sidebar-heading">
                    <img src="{{ asset('/images/avatars/' . Auth::user()->avatar) }}">
                    <h4 class="mb-0">
                        <strong>
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </strong>
                    </h4>
                    <p class="mb-0">
                        {{ Auth::user()->username }}
                    </p>
                </div>
                <div class="list-group list-group-flush">
                    <a {{ Request::url() != route('home') ? 'href=' . route('home') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('home') ? 'active' : ''}}">
                        <i class="icon-home"></i>{{ __(' Home') }}
                    </a>

                    <a {{ Request::url() != route('profile') ? 'href=' . route('profile') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('profile') ? 'active' : ''}}">
                        <i class="icon-profile"></i>{{ __(' Profile') }}
                    </a>

                    @if (Auth::user()->is_admin)

                        <a {{ Request::url() != route('facebook.streaming') ? 'href=' . route('facebook.streaming') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('facebook.streaming') ? 'active' : ''}}">
                            <i class="icon-facebook"></i>{{ __(' Facebook Live') }}
                        </a>

                        <a {{ Request::url() != route('members') ? 'href=' . route('members') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('members') ? 'active' : ''}}">
                            <i class="icon-home"></i>{{ __(' Members List') }}
                        </a>
                        
                        <a {{ Request::url() != route('kumusta') ? 'href=' . route('kumusta') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('kumusta') ? 'active' : ''}}">
                            <i class="icon-kumusta"></i>{{ __(' Kumusta! Kabayan') }}
                        </a>
                        
                        <a {{ Request::url() != route('greetings') ? 'href=' . route('greetings') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('greetings') ? 'active' : ''}}">
                            <i class="icon-greeting"></i>{{ __(' Welcome Greetings') }}
                        </a>

                    @else
                        <a {{ Request::url() != route('print') ? 'href=' . route('print') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('print') ? 'active' : ''}}">
                            <i class="icon-print"></i>{{ __(' Print ID') }}
                        </a>

                        <a {{ Request::url() != route('saklolo') ? 'href=' . route('saklolo') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('saklolo') ? 'active' : ''}}">
                            <i class="icon-saklolo"></i>{{ __(' Saklolo!') }}
                        </a>
                    @endif

                    <a href="https://play.google.com/store/apps/details?id=com.lexmeet&hl=fil&gl=US" target="_blank" class="list-group-item list-group-item-action">
                        <i class="icon-lexmeet"></i>{{ __(' Legal Assistance') }}
                    </a>

                    <a {{ Request::url() != route('discounts') ? 'href=' . route('discounts') : '' }} class="list-group-item list-group-item-action {{ Request::url() == route('discounts') ? 'active' : ''}}">
                        <i class="icon-discount"></i>{{ __(' Discounts') }}
                    </a>

                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon-logout"></i>{{ __(' Log Out') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <button class="navbar-button mr-0 mr-lg-auto" id="menu-toggle"><i class="icon-menu"></i></button>
                    <img class="navbar-logo mx-auto ml-lg-0 mr-lg-4 pr-4 pr-lg-0" src="{{ asset('/images/assets/akoofw_logo.png') }}">
                </nav>
                <main class="p-4">    
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
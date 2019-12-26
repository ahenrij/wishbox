<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WishBox') }}</title>

    <!-- Scripts -->
    <script src="{{ ('js/app.js') }}" defer></script>

    <!-- Fonts -->
{{--<link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

<!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/css/uikit.min.css" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600"/>
    <link rel="stylesheet" href="{{ ('css/all.min.css') }}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ ('css/templatemo-style.css') }}"/>
    <link rel="stylesheet" href="{{ ('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row tm-brand-row">
            <div class="col-lg-4 col-10">
                <div class="tm-brand-container">
                    <div class="tm-brand-texts">
                        <h1 class="text-primary tm-brand-name" onclick="window.location.href='{{ url('/') }}'" style="font-family: 'Century Gothic'; font-weight: 600; cursor: pointer">{{ config('app.name', 'WishBox') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-2 tm-nav-col">
                <div class="tm-nav">
                    <nav class="navbar navbar-expand-lg navbar-light tm-navbar">
                        <button
                                class="navbar-toggler"
                                type="button"
                                data-toggle="collapse"
                                data-target="#navbarNav"
                                aria-controls="navbarNav"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav" style="min-width: 300px !important;">
                            <ul class="navbar-nav ml-auto mr-0">
                                @guest
                                <li class="nav-item active">
                                    <div class="tm-nav-link-highlight"></div>
                                    <a class="nav-link" href="{{ url('login') }}"
                                    >Connexion <span class="sr-only">(current)</span></a
                                    >
                                </li>
                                <li class="nav-item">
                                    <div class="tm-nav-link-highlight"></div>
                                    <a class="nav-link" href="{{ url('register') }}">Inscription</a>
                                </li>
                                @else
                                <li class="nav-item active">
                                    <div class="tm-nav-link-highlight"></div>
                                    <a class="nav-link" href="{{ route('home') }}">Accueil <span class="sr-only">(current)</span></a
                                    >
                                </li>
                                <li class="nav-item">
                                    <div class="tm-nav-link-highlight"></div>
                                    <a class="nav-link" href="{{ route('profile') }}">Profil</a>
                                </li>
                                <li class="nav-item">
                                    <div class="tm-nav-link-highlight"></div>
                                    <a class="nav-link" href="{{ route('wishbox.index') }}">Je souhaite</a>
                                </li>
                                <li class="nav-item">
                                    <div class="tm-nav-link-highlight"></div>
                                    <a class="nav-link" href="{{ route('giftbox') }}">Je donne !</a>
                                </li>
                                <li class="nav-item">
                                    <div class="tm-nav-link-highlight"></div>
                                    <a class="nav-link" href="{{ route('about') }}">A propos</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
<script src="{{ ('js/jquery.min.js') }}"></script>
<script src="{{ ('js/parallax.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="{{ ('js/bootstrap.min.js') }}"></script>
</body>
</html>

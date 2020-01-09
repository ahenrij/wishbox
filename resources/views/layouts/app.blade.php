<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WishBox') }}</title>

    <!-- Styles -->
    <link rel="icon" type="image/png" href="{{ URL::to('/').('/img/favicon.png') }}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/css/uikit.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600"/>
    <link rel="stylesheet" href="{{ URL::to('/'). ('/css/all.min.css') }}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::to('/'). ('/css/templatemo-style.css') }}"/>
    <link rel="stylesheet" href="{{ URL::to('/'). ('/css/app.css') }}" rel="stylesheet">

    @yield('additionalPageStylesheets')

</head>
<body>
<div class="container-fluid">
    <div class="row tm-brand-row">
        <div class="col-lg-4 col-10">
            <div class="tm-brand-container">
                <div class="tm-brand-texts">
                    <h1 class="text-primary tm-brand-name" onclick="window.location.href='{{ url('/') }}'"
                        style="font-family: 'Century Gothic'; font-weight: 600; cursor: pointer">{{ config('app.name', 'WishBox') }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-2 tm-nav-col">
            <div class="tm-nav">
                <nav class="navbar navbar-expand-lg navbar-light tm-navbar">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav" style="min-width: 300px !important;">
                        @include('layouts.nav')
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
</div>
<script src="{{ URL::to('/'). ('/js/jquery.min.js') }}"></script>
<script src="{{ URL::to('/'). ('/js/parallax.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="{{ URL::to('/'). ('/js/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit-icons.min.js"></script>
<script src="{{ URL::to('/'). ('/js/app.js') }}"></script>
<script src="{{ URL::to('/'). ('/js/theme_options.js') }}"></script>

<script type="text/javascript">
  var html = document.getElementsByTagName('html')[0];
  @if (Cookie::get('theme-preference') != null)
  // Get options corresponding to cookie value and pass to function
  applyTheme(themeOptions["{!! Cookie::get('theme-preference') !!}"], html);
@else
applyTheme(themeOptions["Theme1"], html);
    @endif
</script>

@yield('additionalPageScripts')

</body>
</html>

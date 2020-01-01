<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WishBox') }}</title>
</head>
<body>
    <h1>WishBox</h1>
    <small>Il suffit de demander...</small>
    @yield('content')
    <p>L'équipe WishBox</p>
</body>
</html>

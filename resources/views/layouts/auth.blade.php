<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth')</title>

    {{-- Your Vite bundle (should import bootstrap + adminlte) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="@yield('body-class')" data-page="{{ Route::currentRouteName() }}">
    @yield('content')
  </body>
</html>

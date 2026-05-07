<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard')</title>
  <script>
    (() => {
      'use strict';
      
      const storedTheme = localStorage.getItem('theme');
      
      const getPreferredTheme = () => {
        if (storedTheme) {
          return storedTheme;
        }
        
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      };
      
      const setTheme = function (theme) {
        if (theme === 'auto') {
          document.documentElement.setAttribute(
          'data-bs-theme',
          window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
          );
        } else {
          document.documentElement.setAttribute('data-bs-theme', theme);
        }
      };
      
      setTheme(getPreferredTheme());
    })();
  </script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary" data-page="{{ Route::currentRouteName() }}" @if(session('error')) data-error-message="{{ session('error') }}" @elseif(session('success')) data-success-message="{{ session('success') }}" @endif>
  <div class="app-wrapper">
    @include('layouts.dashboard.topnav')
    @include('layouts.dashboard.sidebar')
    
    <main class="app-main">
      <div class="app-content">
        <div class="container-fluid">
          @yield('content')
        </div>
      </div>
    </main>
    
    @include('layouts.dashboard.footer')
  </div>
</body>
</html>

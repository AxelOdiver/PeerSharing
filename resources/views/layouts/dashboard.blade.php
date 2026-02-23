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
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      @include('layouts.dashboard.topnav')
      @include('layouts.dashboard.sidebar')

      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">@yield('page-title', 'Dashboard')</h3>
              </div>
            </div>
          </div>
        </div>
        <div class="app-content">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
      </main>

      @include('layouts.dashboard.footer')
    </div>

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

        const showActiveTheme = (theme, focus = false) => {
          const themeSwitcher = document.querySelector('#bd-theme');

          if (!themeSwitcher) {
            return;
          }

          const themeSwitcherText = document.querySelector('#bd-theme-text');
          const activeThemeIcon = document.querySelector('.theme-icon-active i');
          const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`);
          const iconOfActiveBtn = btnToActive.querySelector('i').getAttribute('class');

          document.querySelectorAll('[data-bs-theme-value]').forEach((element) => {
            element.setAttribute('aria-pressed', 'false');
            element.querySelector('.bi-check-lg').classList.add('d-none');
          });

          btnToActive.setAttribute('aria-pressed', 'true');
          btnToActive.querySelector('.bi-check-lg').classList.remove('d-none');
          activeThemeIcon.setAttribute('class', iconOfActiveBtn);
          const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`;
          themeSwitcher.setAttribute('aria-label', themeSwitcherLabel);

          if (focus) {
            themeSwitcher.focus();
          }
        };

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
          const storedTheme = localStorage.getItem('theme');
          if (storedTheme !== 'light' && storedTheme !== 'dark') {
            setTheme(getPreferredTheme());
          }
        });

        window.addEventListener('DOMContentLoaded', () => {
          showActiveTheme(getPreferredTheme());

          document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
            toggle.addEventListener('click', () => {
              const theme = toggle.getAttribute('data-bs-theme-value');
              localStorage.setItem('theme', theme);
              setTheme(theme);
              showActiveTheme(theme, true);
            });
          });
        });
      })();
    </script>

    @stack('scripts')
  </body>
</html>

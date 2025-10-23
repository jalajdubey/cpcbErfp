<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard')</title>

  {{-- ✅ Load CSS early --}}
  @vite(['resources/css/loggedin.css'])
</head>

<body data-page="{{ Route::currentRouteName() }}" class="@yield('body-class')" data-role="guest">

  {{-- Sidebar + Navbar --}}
  @include('layouts.sidebar')
  @include('layouts.top-navbar')

  {{-- ✅ Dashboard Main Content --}}
  <main class="main-panel">
    <div class="container-fluid py-4">
      @yield('dashboard-content')
    </div>
  </main>

  @includeIf('partials.footer')

  {{-- ✅ Important: put JS after dashboard content --}}
  {{-- This ensures window.dashboardData is defined BEFORE JS loads --}}
  @yield('scripts')

  {{-- ✅ JS loads LAST — now admin.dashboard.js will always find data and canvas --}}
  @vite(['resources/js/loggedin.js'])
</body>
</html>

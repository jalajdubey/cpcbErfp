<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Environmental Relief Fund (ERF)')</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon">

    {{-- Vite Build: Bootstrap + jQuery + KaiAdmin + Custom CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page-specific styles (optional) --}}
    @stack('styles')
</head>

<body style="background-color: #f1f2f3ff;">

    {{-- Global Header --}}
    @include('home.header')

    {{-- Page Content --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Global Footer --}}
    @include('home.footer')

    {{-- Page-specific Scripts --}}
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Environmental Relief Fund (ERF)')</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('images/kaiadmin/favicon.ico') }}" type="image/x-icon">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Vite build: Bootstrap + jQuery + KaiAdmin + Plugins + Custom Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-page="{{ Route::currentRouteName() }}" class="@yield('body-class')">

    {{-- Global Header --}}
    @include('home.header')

    {{-- Page-Specific Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Global Footer --}}
    @include('home.footer')

</body>
</html>

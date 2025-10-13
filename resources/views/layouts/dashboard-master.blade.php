<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    {{-- ✅ Load compiled CSS/JS via Vite --}}
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body>
    {{-- ======================================================
        🧩 ADMIN DASHBOARD LAYOUT
        - Sidebar (role-aware)
        - Navbar (top bar)
        - Main content area
    ======================================================= --}}

    {{-- ✅ Sidebar --}}
    @includeIf('layouts.partials.admin-sidebar')

    {{-- ✅ Top Navbar --}}
    @includeIf('layouts.partials.admin-navbar')

    {{-- ✅ Main Content --}}
    <main class="main-panel">
        @yield('content')
    </main>

</body>
</html>

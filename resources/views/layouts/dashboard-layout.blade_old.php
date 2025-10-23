{{-- resources/views/layouts/dashboard-layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    {{-- ✅ Global logged-in assets --}}
    @vite(['resources/css/loggedin.css', 'resources/js/loggedin.js'])
    @stack('styles')
</head>

<body class="dashboard-body" data-role="{{ Auth::user()->role_type_name ?? 'guest' }}">
    {{-- ✅ Fixed sidebar (left) --}}
    @include('layouts.sidebar')

    {{-- ✅ Fixed top navbar (aligned with sidebar offset) --}}
    @include('layouts.top-navbar')

    {{-- ✅ Main content panel --}}
    <main class="main-panel" 
        style="
            margin-left: 250px;
            padding-top: 60px;
            min-height: 100vh;
            background-color: #f5f6fa;
            transition: all 0.3s ease;
        ">
        <div class="dashboard-container" style="padding: 20px;">
            @yield('dashboard-content')
        </div>
    </main>

    {{-- ✅ Optional footer --}}
    @includeWhen(View::exists('layouts.footer'), 'layouts.footer')

    @stack('scripts')
</body>
</html>

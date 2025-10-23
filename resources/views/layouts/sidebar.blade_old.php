@php
    use Illuminate\Support\Facades\Route;
    $user = Auth::user();
    $currentRoute = Route::currentRouteName();
@endphp

{{-- =====================================================
     SIDEBAR COMPONENT
====================================================== --}}
<aside class="sidebar">
    {{-- ✅ Logo Header --}}
    <div class="sidebar-header">
        <h5 class="sidebar-title">Welcome to ERF Portal</h5>

        {{-- Mobile toggle button (visible only on small screens) --}}
        <button class="toggle-sidebar">
            <i class="fa fa-bars"></i> Menu
        </button>
    </div>

    {{-- ✅ Sidebar Navigation --}}
    <div class="sidebar-nav">
        <ul class="nav flex-column">
            {{-- 🏠 Common Dashboard --}}
            @if ($user && $user->role_type != '4')
                <li class="nav-item {{ in_array($currentRoute, ['admin.dashboard', 'industries.dashboard']) ? 'active' : '' }}">
                    <a href="{{ $user->role_type == '3' ? route('industries.dashboard') : route('admin.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>
            @endif

            {{-- 💼 Insurance User Dashboard --}}
            @if ($user && $user->role_type == '4')
                <li class="nav-item {{ $currentRoute === 'insurance.dashboard' ? 'active' : '' }}">
                    <a href="{{ route('insurance.dashboard') }}">
                        <i class="fas fa-home me-2"></i> Home
                    </a>
                </li>

                <li class="nav-item {{ $currentRoute === 'insurance.primary.details' ? 'active' : '' }}">
                    <a href="{{ route('insurance.primary.details') }}">
                        <i class="fas fa-edit me-2"></i> Add Primary Details
                    </a>
                </li>
            @endif

            {{-- 🔑 Change Password --}}
            <li class="nav-item {{ $currentRoute === 'password.change' ? 'active' : '' }}">
                <a href="{{ route('password.change') }}">
                    <i class="fa fa-key me-2"></i> Change Password
                </a>
            </li>

            {{-- 🧾 Industry Policy Verification --}}
            @if ($user && $user->role_type == '3')
                <li class="nav-item {{ $currentRoute === 'policy.check.form' ? 'active' : '' }}">
                    <a href="{{ route('policy.check.form') }}">
                        <i class="fa fa-lock me-2"></i> Policy Data Verification
                    </a>
                </li>
            @endif
        </ul>
    </div>
</aside>

@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

{{-- =====================================================
     ADMIN SIDEBAR (Dynamic by Role)
====================================================== --}}
<aside class="sidebar" style="background:#084095 !important;">
    {{-- Logo / Header --}}
    <div class="sidebar-logo">
        <div class="logo-header text-center py-3">
            <a href="#" class="logo text-white fw-bold fs-5">
                Welcome to ERF Portal
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar" aria-label="Toggle Sidebar">
                    <i class="gg-menu-right text-white"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler" aria-label="Toggle Sidenav">
                    <i class="gg-menu-left text-white"></i>
                </button>
            </div>

            <button class="topbar-toggler more" aria-label="More Options">
                <i class="gg-more-vertical-alt text-white"></i>
            </button>
        </div>
    </div>

    {{-- Sidebar Navigation --}}
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                {{-- 🏠 Common Dashboard (Admin / Industry / CPCB) --}}
                @if ($user && $user->role_type != '4')
                    <li class="nav-item">
                        <a href="{{ $user->role_type == '3' ? route('industries.dashboard') : route('admin.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif

                {{-- 🏢 Insurance Role (role_type == 4) --}}
                @if ($user && $user->role_type == '4')
                    <li class="nav-item">
                        <a href="{{ route('insurance.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-edit"></i>
                            <p>Add Primary Details</p>
                        </a>
                    </li>
                @endif

                {{-- 🔐 Change Password (All Roles) --}}
                <li class="nav-item">
                    <a href="{{ route('password.change') }}">
                        <i class="fa fa-key"></i>
                        <p>Change Password</p>
                    </a>
                </li>

                {{-- 🧾 Industry Role: Policy Verification --}}
                @if ($user && $user->role_type == '3')
                    <li class="nav-item">
                        <a href="{{ route('policy.check.form') }}">
                            <i class="fa fa-lock"></i>
                            <p>Policy Data Verification</p>
                        </a>
                    </li>
                @endif

                {{-- 🚪 Logout --}}
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

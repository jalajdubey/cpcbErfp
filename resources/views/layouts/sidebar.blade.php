@php
    $user = Auth::user();
@endphp

{{-- =====================================================
     SIDEBAR COMPONENT
====================================================== --}}
<div class="sidebar" style="background:#084095 !important;">
    {{-- Logo / Header --}}
    <div class="sidebar-logo">
        <div class="logo-header text-center">
            <a class="logo mt-3 text-1">Welcome to ERF Portal</a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar" aria-label="Toggle Sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler" aria-label="Toggle Sidenav">
                    <i class="gg-menu-left"></i>
                </button>
            </div>

            <button class="topbar-toggler more" aria-label="More Options">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>

    {{-- Sidebar Navigation --}}
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                {{-- Common Dashboard --}}
                @if ($user && $user->role_type != '4')
                    <li class="nav-item">
                        @if ($user->role_type == '3')
                            <a href="{{ route('industries.dashboard') }}">
                        @else
                            <a href="{{ route('admin.dashboard') }}">
                        @endif
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                    </li>
                @endif

                {{-- Role Type == 4: Insurance User --}}
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

                {{-- Common to All Roles --}}
                <li class="nav-item">
                    <a href="{{ route('password.change') }}">
                        <i class="fa fa-key"></i>
                        <p>Change Password</p>
                    </a>
                </li>

                {{-- Industry Role: Policy Verification --}}
                @if ($user && $user->role_type == '3')
                    <li class="nav-item">
                        <a href="{{ route('policy.check.form') }}">
                            <i class="fa fa-lock"></i>
                            <p>Policy Data Verification</p>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

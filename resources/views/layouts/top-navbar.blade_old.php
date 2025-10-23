<nav id="dashboardNavbar" class="navbar navbar-dashboard">
  <button class="btn-toggle toggle-sidebar">
    <i class="fa fa-bars"></i>
  </button>

  <a href="{{ route('admin.dashboard') }}" class="navbar-brand">ERF Portal</a>

  <div class="dropdown profile-dropdown">
    <a href="#" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
      <img src="{{ asset('images/profile.jpg') }}" alt="User" class="profile-avatar">
      <span>{{ Auth::user()->firstname ?? 'Guest' }}</span>
      <i class="fa fa-caret-down ms-2"></i>
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
      <li class="dropdown-header small text-muted px-3">{{ Auth::user()->email ?? '' }}</li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="dropdown-logout-btn">
            <i class="fa fa-sign-out-alt me-2"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </div>
</nav>

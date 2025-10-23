{{-- =====================================================
     🧭 Top Navbar (ERF Dashboard – KaiAdmin Lite Compatible)
====================================================== --}}
<nav id="dashboardNavbar" class="navbar navbar-dashboard navbar-expand-lg">
  <div class="container-fluid d-flex justify-content-between align-items-center">

    {{-- 🟦 Sidebar Toggle (mobile only) --}}
    <button
      class="btn btn-toggle d-lg-none border-0 bg-transparent text-white toggle-sidebar"
      type="button"
      aria-label="Toggle sidebar"
      data-bs-toggle="tooltip"
      data-bs-placement="bottom"
      title="Toggle sidebar">
      <i class="fa fa-bars"></i>
    </button>

    {{-- 🏛️ Brand --}}
    <a href="{{ route('admin.dashboard') }}"
       class="navbar-brand text-white fw-semibold text-uppercase mb-0">
      ERF Portal
    </a>

    {{-- 👤 Profile Dropdown --}}
    <div class="dropdown profile-dropdown">
      <a href="#"
         class="dropdown-toggle d-flex align-items-center text-white"
         id="profileDropdown"
         data-bs-toggle="dropdown"
         aria-expanded="false"
         aria-label="User menu">
        <img src="{{ asset('images/profile.jpg') }}"
             alt="User Avatar"
             class="profile-avatar me-2">
        <span class="fw-medium">{{ Auth::user()->firstname ?? 'Guest' }}</span>
        <i class="fa fa-caret-down ms-2"></i>
      </a>

<<<<<<< Updated upstream


      <li class="nav-item topbar-user dropdown hidden-caret">
        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
          <div class="avatar-sm">
            <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
          </div>
          <span class="profile-username">
            <span class="op-7 text-white">Hi,</span>
            <!-- <span class="fw-bold text-white">Hizrian</span> -->
            @if(auth()->check())
        <span class="fw-bold text-white">Welcome, {{ auth()->user()->firstname }}</span>
      @endif


          </span>
        </a>
        <ul class="dropdown-menu dropdown-user animated fadeIn">
          <div class="scroll-wrapper dropdown-user-scroll scrollbar-outer" style="position: relative;">
            <div class="dropdown-user-scroll scrollbar-outer scroll-content"
              style="height: auto; margin-bottom: -17px; margin-right: -17px; max-height: 17px;">

              <li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  @if(auth()->check())


            <span class="fw-bold text-dark">Welcome, {{ auth()->user()->email }}</span>

          @endif
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Account Setting</a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>

              </li>
            </div>
            <div class="scroll-element scroll-x">
              <div class="scroll-element_outer">
                <div class="scroll-element_size"></div>
                <div class="scroll-element_track"></div>
                <div class="scroll-bar"></div>
              </div>
            </div>
            <div class="scroll-element scroll-y">
              <div class="scroll-element_outer">
                <div class="scroll-element_size"></div>
                <div class="scroll-element_track"></div>
                <div class="scroll-bar"></div>
              </div>
            </div>
          </div>
        </ul>
      </li>
    </ul>
=======
      <ul class="dropdown-menu dropdown-menu-end shadow-sm"
          aria-labelledby="profileDropdown">
        <li class="dropdown-header small text-muted px-3">
          {{ Auth::user()->email ?? 'guest@example.com' }}
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
            @csrf
            <button type="submit" class="dropdown-logout-btn w-100 text-start">
              <i class="fa fa-sign-out-alt me-2"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
>>>>>>> Stashed changes
  </div>
</nav>

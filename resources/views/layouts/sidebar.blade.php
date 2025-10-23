<style>
  .text-1 {
    margin-bottom: 40px;
   /* padding-top: 100px;*/
    font-family: Poppins, sans-serif;
    font-style: normal;
    font-weight: 700;
    /* font-size: 20px;
    line-height: 60px; */
    text-align: center;
    background: linear-gradient(90deg, #ffbd00 0%, #08950f 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    /* animation: hue 2s infinite linear; */
    -webkit-animation: hue 2s infinite linear;
}

</style>
@php
    use Illuminate\Support\Facades\Route;
    $user = Auth::user();
<<<<<<< Updated upstream
  
@endphp

      <!-- Sidebar -->
      <div class="sidebar "  style="background:#084095 !important;">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" >
            <a  class="logo mt-3 text-1">
              Welcome to ERF Portal
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
            @if ($user && $user->role_type != '4')
              <li class="nav-item">
                @if ($user && $user->role_type == '3')
                <a href="{{ route('industries.dashboard') }}">
                @else
                <a href="{{ route('admin.dashboard') }}">
                @endif
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
               
              </li>
              <!-- <li class="nav-item">
              <a href="{{ route('insurance-summary') }}">
                    <i class="fas fa-home"></i>
                    <p>Insurance Details Dashboard</p>
                    <span class="caret"></span>
                </a>
            </li> -->
            @endif
             {{-- Role Type == 4: Show Only Add Primary Details & Change Password --}}
        @if ($user && $user->role_type == '4')
        <li class="nav-item">
        <a href="{{ route('insurance.dashboard') }}">
              <i class="fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>
        
          <li class="nav-item">
            <a href="">
              <i class="fas fa-home"></i>
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
     
=======
    $currentRoute = Route::currentRouteName();
@endphp

<aside class="sidebar sidebar-erf d-flex flex-column">
  {{-- Logo Header --}}
  <div class="sidebar-logo text-center py-3 border-bottom">
    <h5 class="m-0 fw-semibold text-uppercase">ERF Dashboard</h5>
  </div>

  {{-- Sidebar Navigation --}}
  <div class="sidebar-wrapper flex-grow-1">
    <ul class="nav flex-column">

      {{-- 🏠 Dashboard --}}
      <li class="nav-item {{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">
          <i class="fas fa-home me-2"></i> <span>Dashboard</span>
        </a>
      </li>

      {{-- 💼 Insurance Role --}}
      @if($user && $user->role_type == 4)
        <li class="nav-item {{ $currentRoute === 'insurance.dashboard' ? 'active' : '' }}">
          <a href="{{ route('insurance.dashboard') }}">
            <i class="fas fa-briefcase me-2"></i> <span>Insurance Home</span>
          </a>
        </li>
      @endif

      {{-- 🏭 Industry Role --}}
      @if($user && $user->role_type == 3)
        <li class="nav-item {{ $currentRoute === 'industry.dashboard' ? 'active' : '' }}">
          <a href="{{ route('industry.dashboard') }}">
            <i class="fas fa-industry me-2"></i> <span>Industry Home</span>
          </a>
        </li>
      @endif

      {{-- 🔑 Change Password --}}
      <li class="nav-item {{ $currentRoute === 'password.change' ? 'active' : '' }}">
        <a href="{{ route('password.change') }}">
          <i class="fa fa-key me-2"></i> <span>Change Password</span>
        </a>
      </li>
    </ul>
  </div>

  {{-- Sidebar Footer (Collapse Button) --}}
 <div class="sidebar-footer">
  <button id="sidebarCollapseBtn">
    <i class="fa fa-angle-double-left"></i> <span>Collapse</span>
  </button>
</div>
</aside>

>>>>>>> Stashed changes

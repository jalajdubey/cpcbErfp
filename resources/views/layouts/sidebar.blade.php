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
    $user = Auth::user();
  
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
              <a href="{{ route('admin.dashboard') }}">
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

      </ul>
          </div>
        </div>
        
      </div>
     
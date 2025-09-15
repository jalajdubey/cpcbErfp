<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" style="margin-top:-5px">
  <div class="container-fluid">


    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
      <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"
          aria-haspopup="true">
          <i class="fa fa-search"></i>
        </a>
        <!-- <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input type="text" placeholder="Search ..." class="form-control">
                      </div>
                    </form>
                  </ul> -->
      </li>




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
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit">Logout</button>
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
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

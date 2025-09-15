<style>
    #navbar ul li a{
        background: #084095;
    color: #ffffff !important;
    padding: 3px;
    font-size: 15px;
    }
    #mainnav{
         background: linear-gradient(45deg, #108e16, #084095) !important;
    }
     .top-header-box {
    background: linear-gradient(45deg, #108e16, #084095);

    padding: 5px 0;
    display: flex;
    align-items: center;
    justify-content: space-between; /* keeps logo left, other content right or center */
    height: 82px;
    position: relative;
    color: #fff; /* Optional: makes heading text readable on dark background */
}

.top-header-box-inner {
    display: flex
;
    justify-content: space-between;
    align-items: center;
}
.top-header-box-inner h3.top-header-center span
{
    font-weight: 600;
    font-size: 22px;
}
.top-header-box-inner h3.top-header-center {
    margin: 0;
    color: #fff;
    font-weight: 500;
    font-size: 18px;
    text-align: center;
}
.top-header-left {
    width: 240px;
}
img, video {
    max-width: 100%;
    height: auto;
}
.top-header-box-innerh3.top-header-center{
    margin: 0;
    color: #fff;
    font-weight: 500;
    font-size: 18px;
    text-align: center;
        line-height: 28px;
    font-family: 'Cabin', sans-serif;
    letter-spacing: .009375em;
}

.top-header-right {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #fff;
    font-size: 13px;
}
.top-header-box {
    padding: 10px 0;
    background-color: #f8f9fa;
    border-bottom: 1px solid #ccc;
}

.top-header-left img {
    max-height: 60px;
}
.btn {
  background: transparent;
  color: #000;
}
.btn:hover {
  color: #0d6efd;
  text-decoration: underline;
}

.nav-link {
  transition: all 0.2s ease;
}
.nav-link:hover {
  color: #0d6efd;
  text-decoration: underline;
}
.nav-link a{
      display: inline-block;
    vertical-align: middle;
    color:#fff !important;
    position: relative;
    font-size: 13px;
    font-weight: 400;
    text-align: center;
    padding: 8px 14px;
    border-radius: 3px;
    transition: 0.3s;
}


</style>
<link href="https://fonts.googleapis.com/css?family=Cabin:500,600,700|Kanit:200,300,300i,400" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" includes Popper.js></script>

    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/css2.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/kaiadmin.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('assets/css/plugins.min.css') }}" rel="stylesheet" type="text/css">


     <div class="top-header-box">
    <div class="container top-header-box-inner d-flex align-items-center position-relative">
        <!-- Left-aligned logo -->
        <div class="top-header-left">
            <img src="assets/gov_logo.png" alt="Gov Logo" class="img-fluid" style="max-height: 60px;">
        </div>

        <!-- Center-aligned heading -->
        <h3 class="top-header-center notranslate m-0 position-absolute start-50 translate-middle-x text-center w-100">
            <span class="notranslate">ENVIRONMENT RELIEF FUND SCHEME MANAGEMENT SYSTEM</span><br>
              (Portal under the Environment Relief Fund Scheme, 2024)
        </h3>
    </div>
</div>
<!------header bottom---->

<div class="container-fluid">
  <div class="container">
     <div class="row">
  <div class="col-sm-6">
    <div class="col-sm-12">
  <ul class="d-flex list-unstyled align-items-center" style="gap: 20px; margin-top: 20px; margin-bottom: 20px;">
    
    <!-- Logo 1 -->
    <li>
      <img src="{{ asset('images/cpcb_logo.png') }}" alt="Image 1" class="img-fluid" style="height: 70px;">
    </li>

    <!-- Separator 1 -->
    <li style="height: 50px; border-left: 2px solid #ccc;"></li>

    <!-- Logo 2 -->
    <li>
      <img src="{{ asset('images/life_logo.png') }}" alt="Image 2" class="img-fluid" style="height: 70px;">
    </li>

    <!-- Separator 2 -->
    <li style="height: 50px; border-left: 2px solid #ccc;"></li>

    <!-- Logo 3 with text -->
    <li class="d-flex align-items-center">
      <img src="{{ asset('images/ministry_logo.png') }}" alt="Image 3" class="img-fluid me-2" style="height: 70px;">
      <div style="max-width: 250px;">
        <strong>
          Ministry of Environment, Forest<br>
          and Climate Change,<br>
          Government of India
        </strong>
      </div>
    </li>

  </ul>
</div>

  </div>
  <div class="col-sm-6 d-flex justify-content-end align-items-center" style="height: 100px;">
  <div class="d-flex align-items-center gap-3">
    
    <!-- Button 1 -->
    <button type="button" class="btn border-0 fw-bold px-3" style="font-size:20px">
        <a href="{{ route('policy.check.form') }}" class="custom-login-btn">
      Sign up
        </a>
    </button>

    <!-- Vertical Separator -->
    <div style="width: 1px; height: 24px; background-color: #ccc;"></div>

    <!-- Button 2 -->
    <button type="button" class="btn border-0 fw-bold px-3" style="font-size:20px">
      Dashboard
    </button>

    <!-- Vertical Separator -->
    <div style="width: 1px; height: 24px; background-color: #ccc;"></div>

    <!-- Button 3 (Link to Login) -->
    <a href="{{ route('login') }}" class="custom-login-btn">
  Login
</a>

  </div>
</div>


</div>

  </div>
</div>





<!-----end header-bootom------>

<!-----navigation section--->
<nav class="navbar navbar-expand-lg navbar-light " id="mainnav">
  <div class="container-fluid">
    <!-- Brand/logo (optional) -->
    <div class="container">

    <!-- Toggler for mobile view -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse w-100" id="navbarNav">
      <!-- LEFT-aligned nav items -->
    <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">
  <li class="nav-item">
    <a class="nav-link custom-nav-link active" href="{{ route('home') }}">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link custom-nav-link" href="{{ route('aboutus') }}">About</a>
  </li>
  <li class="nav-item">
    <a class="nav-link custom-nav-link" href="{{ route('pilandErf') }}">PIL & ERF</a>
  </li>
  <li class="nav-item">
    <a class="nav-link custom-nav-link" href="{{ route('actandRule') }}">Act & Rules</a>
  </li>
  <li class="nav-item">
    <a class="nav-link custom-nav-link" href="{{ route('stakeholder') }}">Stake Holders</a>
  </li>
  <li class="nav-item">
    <a class="nav-link custom-nav-link" href="{{ route('annualReport') }}">Annual Audit Report</a>
  </li>
  <li class="nav-item">
    <a class="nav-link custom-nav-link" href="{{ route('faqM') }}">FAQ</a>
  </li>
</ul>


      <!-- RIGHT-aligned optional section (e.g., login button) -->
      <div class="d-flex">
        <!-- Example: -->
        <!-- <a href="#" class="btn btn-outline-primary btn-sm fw-bold">Login</a> -->
      </div>
    </div>
  </div>
  </div>
</nav>

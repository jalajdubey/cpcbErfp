<style>
    #navbar ul li a{
        background: #084095;
    color: #ffffff !important;
    padding: 3px;
    font-size: 15px;
    }
    nav { background: #084095 !important; color: #ffffff; padding: 3px; font-size: 15px; }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" includes Popper.js></script>

    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('assets/css/kaiadmin.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('assets/css/plugins.min.css') }}" rel="stylesheet" type="text/css">

<div class="header-top">
  <div class="container-fluid">
    <div class="row my-3">
        <div class="col-md-4 col-sm-12 col-xs-12">
        <ul class="list-group list-group-horizontal logo-list logo-mob">
            <li><p><a href="#/"><img alt="" src="https://cpcb.nic.in/images/golden_jubilee_logo.png" style="width:100px" class="img-fluid"> </a>
        </p></li>
        <li>
            <div class="mt-3 mefcc">
            <p class="main-heading">Central Pollution Control Board </p>
            <p class="mb-0">Ministry of Environment, Forest and Climate Change</p></div></li>
        </ul>
        </div><!--left cloased---->
        <div class="col-md-4 col-sm-12 col-xs-12">
        <h4 class="mt-2 mref" style="color:linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);">
             ENVIRONMENT RELIEF FUND SCHEME MANAGEMENT SYSTEM
        </h4>
        <h5 style="font-size:12px">(Portal under the Environment Relief Fund Scheme, 2024)</h5>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
        <ul class="list-unstyled d-flex justify-content-end"> <!-- Add justify-content-end for right alignment -->
    <li class="me-3">
        <p>
            <a href='#/'>
                <img src="{{ asset('images/life_logo.png') }}" alt="Life Logo">
            </a>
        </p>
    </li>
    <li>
        <p>
            <a href='#/'>
                <img src="{{ asset('images/ministry_logo.png') }}" alt="Ministry Logo">
            </a>
        </p>
    </li>
</ul>


        </div>
    </div>
  </div>
</div>
<!-----navigation section--->
<nav class="navbar navbar-expand-lg " id="navbar">
        <div class="container-fluid">
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">SOP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Important Communication</a>
                    </li>
                </ul>
                <div class="ms-auto">
  
    <a href="{{ route('login') }}" class="btn btn-success" role="button">Login</a>
</div>
            </div>
        </div>
    </nav>
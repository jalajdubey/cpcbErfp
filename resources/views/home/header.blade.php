<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Environmental Relief Fund (ERF)</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon">

    {{-- Vite build: Bootstrap + jQuery + KaiAdmin + Plugins + Custom Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-page="{{ Route::currentRouteName() }}">

    {{-- HEADER SECTION --}}
    <div class="top-header-box">
        <div class="container top-header-box-inner d-flex align-items-center position-relative">
            <div class="top-header-left">
                <img src="{{ asset('images/gov_logo.png') }}" alt="Gov Logo" class="img-fluid" style="max-height: 60px;">
            </div>

            <h3 class="top-header-center notranslate m-0 position-absolute start-50 translate-middle-x text-center w-100">
                <span class="notranslate">ENVIRONMENT RELIEF FUND SCHEME MANAGEMENT SYSTEM</span><br>
                (Portal under the Environment Relief Fund Scheme, 2024)
            </h3>
        </div>
    </div>

    {{-- HEADER-BOTTOM SECTION --}}
    <div class="container-fluid">
        <div class="container">
            <div class="row align-items-center py-3">
                <div class="col-sm-6">
                    <ul class="d-flex list-unstyled align-items-center gap-4">
                        <li>
                            <img src="{{ asset('images/cpcb_logo.png') }}" alt="CPCB" class="img-fluid" style="height: 70px;">
                        </li>
                        <li style="height: 50px; border-left: 2px solid #ccc;"></li>
                        <li>
                            <img src="{{ asset('images/life_logo.png') }}" alt="LIFE" class="img-fluid" style="height: 70px;">
                        </li>
                        <li style="height: 50px; border-left: 2px solid #ccc;"></li>
                        <li class="d-flex align-items-center">
                            <img src="{{ asset('images/ministry_logo.png') }}" alt="MoEF" class="img-fluid me-2" style="height: 70px;">
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

                <div class="col-sm-6 d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center gap-3">

                        {{-- Sign Up Dropdown --}}
                        <div class="dropdown">
                            <button class="btn border-0 fw-bold px-4 py-2 dropdown-toggle" type="button"
                                id="signupDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size:20px;">
                                Sign up
                            </button>
                            <ul class="dropdown-menu shadow" aria-labelledby="signupDropdown">
                                <li><a class="dropdown-item" href="{{ route('industry.register') }}">Industry</a></li>
                                <li><a class="dropdown-item" href="{{ route('insurance.register') }}">Insurance Company</a></li>
                            </ul>
                        </div>

                        {{-- Separator --}}
                        <div class="vertical-separator"></div>

                        {{-- Public Dashboard --}}
                        <a class="custom-login-btn" href="{{ route('publicdashboard') }}">
                            <i class="bi bi-bar-chart"></i> Public Dashboard
                        </a>

                        <div class="vertical-separator"></div>

                        {{-- Login Button --}}
                        <a href="{{ route('login') }}" class="custom-login-btn">
                            Login
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- NAVIGATION --}}
    <nav class="navbar navbar-expand-lg navbar-light" id="mainnav">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item"><a class="nav-link custom-nav-link active" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link custom-nav-link" href="{{ route('aboutus') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link custom-nav-link" href="{{ route('pilandErf') }}">PIL & ERF</a></li>
                    <li class="nav-item"><a class="nav-link custom-nav-link" href="{{ route('actandRule') }}">Act & Rules</a></li>
                    <li class="nav-item"><a class="nav-link custom-nav-link" href="{{ route('stakeholder') }}">Stake Holders</a></li>
                    <li class="nav-item"><a class="nav-link custom-nav-link" href="{{ route('annualReport') }}">Annual Audit Report</a></li>
                    <li class="nav-item"><a class="nav-link custom-nav-link" href="{{ route('faqM') }}">FAQ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT AREA --}}
    @yield('content')

</body>
</html>

{{-- resources/views/home.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Environmental Relief Fund (ERF)</title>

    <link rel="icon" href="{{ asset('assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon">

    {{-- Load CSS + JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
</head>

<body>
    {{-- Header --}}
    @include('home.header')

    {{-- Hero Section --}}
    <div class="container-fluid landing-banner-bg">
        <div class="container py-1">
            <div class="row align-items-start">
                <div class="col-lg-12">
                    <div id="landingCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/scheme_2024.png') }}" class="d-block w-100" alt="Slide 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/1.webp') }}" class="d-block w-100" alt="Slide 2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/scheme_2024.png') }}" class="d-block w-100" alt="Slide 3">
                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#landingCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#landingCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Section --}}
    <div class="miupdate updatebg mt-1">
        <div class="container">
            <div class="update-section mt-2">
                <h3>Latest Update:</h3>
            </div>
        </div>
    </div>

    {{-- Info + Announcements --}}
    <div class="container-fluid bg-white">
        <div class="container py-4">
            <div class="row">
                {{-- Left Info Section --}}
                <div class="col-lg-8 mb-4">
                    <h3 class="h3 mb-3 titleh3 custom-underline">
                        ERF Portal for ENVIRONMENT RELIEF FUND SCHEME MANAGEMENT SYSTEM
                    </h3>
                    <p>
                        The Central Pollution Control Board (CPCB) is entrusted with the management
                        of the Environment Relief Fund (ERF) starting January 1, 2025, under the
                        Ministry of Environment, Forest and Climate Change. This initiative aims
                        to ensure efficient fund utilization and timely compensation for industrial
                        accidents involving hazardous substances.
                    </p>

                    <ul class="erf-list">
                        <li>Ensure timely disbursal of compensation.</li>
                        <li>Maintain transparent ERF records.</li>
                        <li>Coordinate with insurance companies for claims.</li>
                        <li>Track industrial compliance.</li>
                        <li>Promote ERF awareness among stakeholders.</li>
                    </ul>
                </div>

                {{-- Right Announcement Section --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-header text-white" style="background-image: linear-gradient(45deg, #108e16, #084095);">
                            <h5 class="mb-0">Important Announcements</h5>
                        </div>
                        <div class="announcement-container">
                            <ul class="list-group list-group-flush announcements">
                                <li class="list-group-item">
                                    <img src="{{ asset('images/new_icon.gif') }}" alt="New" width="30" height="12" class="me-2">
                                    Inviting comments on guidelines for handling waste solar PV modules.
                                </li>
                                <li class="list-group-item">
                                    Timeline for annual returns FY 2023-24 extended to <strong>31st Jan 2025</strong>.
                                </li>
                                <li class="list-group-item">
                                    Environmental Compensation Guidelines under E-Waste (M) Rules, 2022.
                                </li>
                                <li class="list-group-item">Public notice for recyclers dated 21.08.23</li>
                                <li class="list-group-item">Instructions for creating login credentials</li>
                                <li class="list-group-item">Covering letter and undertaking for registration correctness</li>
                                <li class="list-group-item">Notice for Producers & Recyclers</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('home.footer')
</body>
</html>

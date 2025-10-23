@extends('layouts.dashboard-layout')

@section('title', 'Admin Dashboard')


@section('dashboard-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ===============================
         DASHBOARD SUMMARY CARDS
    ================================ --}}
    <div class="card mt-3">
        <h2 class="dashboard-title text-center">
            Environmental Relief Fund (ERF) - CPCB Dashboard
        </h2>

        <div class="row g-4">
            {{-- Total Insurance Companies --}}
            <div class="col-6 col-md-3">
                <div class="dashboard-card">
                    <div>
                        <div class="icon-circle bg-icon-blue">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <div class="dashboard-label">Total Insurance Company Registered</div>
                        <div class="dashboard-count fw-bold text-primary">{{ $uniqueUserCount }}</div>
                    </div>
                    <a href="{{ route('insComplist') }}" class="btn btn-view mt-2">
                        <i class="bi bi-eye me-1"></i> View
                    </a>
                </div>
            </div>

            {{-- Total Policy Issued --}}
            <div class="col-6 col-md-3">
                <div class="dashboard-card">
                    <div>
                        <div class="icon-circle bg-icon-green">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <div class="dashboard-label">Total Number of Policy Issued</div>
                        <div class="dashboard-count text-warning fw-bold">{{ $totalPolicylist }}</div>
                    </div>
                    <a href="{{ route('insurance-summary') }}" class="btn btn-view mt-2">
                        <i class="bi bi-eye me-1"></i> View
                    </a>
                </div>
            </div>

            {{-- Total ERF Contribution --}}
            <div class="col-6 col-md-3">
                <div class="dashboard-card">
                    <div>
                        <div class="icon-circle bg-icon-orange">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="dashboard-label">Total Contribution of ERF Fund (Rs)</div>
                        <div class="dashboard-count text-success fw-bold">
                            {{ format_inr($totalContribution, 2) }}
                        </div>
                    </div>
                    <a href="{{ route('erfcontsummary') }}" class="btn btn-view mt-2">
                        <i class="bi bi-eye me-1"></i> View
                    </a>
                </div>
            </div>

            {{-- Registered Industry --}}
            <div class="col-6 col-md-3">
                <div class="dashboard-card">
                    <div>
                        <div class="icon-circle bg-icon-teal">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="dashboard-label">Registered Industry</div>
                        <div class="dashboard-count">Total: 0</div>
                    </div>
                    <button class="btn btn-view mt-2">
                        <i class="bi bi-eye me-1"></i> View
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===============================
         CHARTS SECTION
    ================================ --}}
    <div class="row mt-4">
        {{-- Monthly ERF Contribution --}}
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm text-center">
                <h5 class="mb-3 text-primary fw-bold">Monthly ERF Contribution</h5>
                <div class="chart-container">
                    <canvas id="monthlyPoliciesChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ERF by Insurance Company --}}
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm text-center">
                <h5 class="mb-3 text-primary fw-bold">ERF Contribution by Insurance Company</h5>
                <div class="chart-container">
                    <canvas id="erfChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Industry vs Insurance --}}
        <div class="card p-4 shadow-sm mt-4">
            <h5 class="text-center mb-3 text-primary fw-bold">
                Insurance Companies Vs Industry Count
            </h5>
            <div class="chart-container">
                <canvas id="industriesByCompanyChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ===============================
         GLOBAL VARIABLES TO JS
    ================================ --}}
    <script>
        window.dashboardData = {
            erfLabels: @json($erfLabels),
            erfAmounts: @json($erfAmounts),
            months: @json($months),
            policyCounts: @json($policyCounts),
            policyAmounts: @json($policyAmounts),
            companyLabels: @json($erfLabels),
            companyIndustries: @json($companyIndustries),
            companyErf: @json($companyErf)
        };
    </script>
@endsection

@include('home.header')

<div class="container-fluid mt-4 mb-5">
    <div class="container">
        <h2 class="text-center mb-4" style="color:#084095; font-weight:bold;">
            Public Dashboard – ERF
        </h2>

        <div class="row">

        <div class="col-md-6 mb-4">
            <a href="{{ route('insurance.industry.report') }}" style="text-decoration:none;">
                <div class="card p-3 shadow-sm text-center dashboard-card">
                    <div class="icon-circle bg-icon-green mb-2">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <h5 class="mb-2" style="color:#084095; font-weight:bold;">
                        Insurance & Industry Summary
                    </h5>
                    <div style="font-size:22px; font-weight:bold; color:#2e7d32;">
                        View Report
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="#" style="text-decoration:none;">
                <div class="card p-3 shadow-sm text-center dashboard-card">
                    <div class="icon-circle bg-icon-green mb-2">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <h5 class="mb-2" style="color:#084095; font-weight:bold;">
                        Total ERF Contribution By Industries
                    </h5>
                    <div style="font-size:22px; font-weight:bold; color:#2e7d32;">
                         {{ $totalErfContributionCr }} Cr
                    </div>
                </div>
            </a>
        </div>
          <!-- Pie Chart -->
           <div class="col-md-6 mb-4">
                <div class="card p-3 shadow-sm text-center">
                    <h5 class="mb-3" style="color:#084095; font-weight:bold;">
                        ERF Contribution by Insurance Company
                    </h5>
                  <div style="height:400px;">
                        <canvas id="erfChart"></canvas>
                    </div>
                    <!-- <div style="margin-top:15px; font-weight:bold; color:#084095;">
                        Total ERF: ₹ {{ number_format($erfTotal, 2) }}
                    </div> -->
                </div>
            </div>

           <!-- Monthly Contribution Chart -->
            <div class="col-md-6 mb-4">
                <div class="card p-3 shadow-sm text-center">
                    <h5 class="mb-3" style="color:#084095; font-weight:bold;">
                         Monthly Policies Taken
                    </h5>
                    <div style="height:400px;">
                        <canvas id="monthlyPoliciesChart"></canvas>
                    </div>
                </div>
            </div>


            <div class="card p-4 shadow-sm mt-4">
            <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
               Industries Insured and ERF Contribution by Insurance Company
            </h5>
            <div style="height:400px;">
                <canvas id="industriesByCompanyChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart -->
            <!-- <div class="col-md-6 mb-4">
                <div class="card p-3 shadow-sm">
                    <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
                        Industries Insured per Insurance Company
                    </h5>
                    <div>
                        <canvas id="policyChart"></canvas>
                    </div>
                </div>
            </div> -->

          <!-- Bar Chart -->
            <div class="col-md-12 mb-4">
                <div class="card p-3 shadow-sm">
                <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
                    Industries Insured per Insurance Company
                </h5>
                <div style="height:400px;">
                    <canvas id="policyChart"></canvas>
                </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card p-4 shadow-sm">
                    <h5 class="mb-3" style="color:#084095; font-weight:bold;">
                        Year-wise Policy & Contribution Summary
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Year</th>
                                    <th>Industries Listed</th>
                                    <th>Policies Taken</th>
                                    <th>Total Premium (₹)</th>
                                    <th>Total ERF Contribution (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($yearWiseData as $row)
                                    <tr>
                                        <td>{{ $row->policy_year }}</td>
                                        <td>{{ $row->industries_count }}</td>
                                        <td>{{ $row->policies_count }}</td>
                                        <td>{{ number_format($row->total_premium, 2) }}</td>
                                        <td>{{ number_format($row->erf_total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('home.footer')

<script>
    window.erfLabels = @json($erfLabels);
    window.erfAmounts = @json($erfAmounts);
    window.industryCounts = @json($industryCounts);
    window.months = @json($months);
    window.policyCounts = @json($policyCounts);
    window.policyAmounts = @json($policyAmounts);
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
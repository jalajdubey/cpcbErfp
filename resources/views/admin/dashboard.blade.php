<style>
 <style>
    /* Base styles */
    body {
      background-color: #f8f9fc;
      font-family: 'Segoe UI', sans-serif;
    }

@section('dashboard-content')

    /* Card layout */
    .dashboard-card {
      background: linear-gradient(to bottom right, #ffffff, #f5f9ff);
      border: 1px solid #dee2e6;
      border-radius: 16px;
      padding: 25px 20px;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .dashboard-card:hover {
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      transform: translateY(-5px);
    }

    /* Icon circle */
    .icon-circle {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      font-size: 20px;
      margin-bottom: 12px;
      color: #fff;
    }

    /* Color options */
    .bg-icon-blue    { background-color: #0d6efd; }
    .bg-icon-green   { background-color: #198754; }
    .bg-icon-orange  { background-color: #fd7e14; }
    .bg-icon-red     { background-color: #dc3545; }
    .bg-icon-teal    { background-color: #20c997; }
    .bg-icon-yellow  { background-color: #ffc107; color: #000; }
    .bg-icon-gray    { background-color: #6c757d; }
    .bg-icon-indigo  { background-color: #6610f2; }

    /* Card text */
    .dashboard-label {
      font-size: 16px;
      font-weight: 600;
      color: #212529;
      margin-bottom: 6px;
    }

    .dashboard-count {
      font-size: 14px;
      color: #6c757d;
    }

    /* View button */
    .btn-view {
      font-size: 13px;
      padding: 5px 18px;
      background-color: #eaf1fb;
      color: #084095;
      border-radius: 25px;
      border: 1px solid #cfe2ff;
      transition: all 0.2s ease;
      font-weight: 500;
    }

    .btn-view:hover {
      background-color: #d0e4ff;
      color: #063073;
      border-color: #a4c7f7;
    }

    /* Responsive tweaks */
    @media (max-width: 576px) {
      .dashboard-card {
        padding: 20px 15px;
      }

      .btn-view {
        width: 100%;
        padding: 6px;
      }
    }
  </style>
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')

  <div class="main-panel">
  
    <div class="card mt-3">
    
    <h2 class="dashboard-title">Environmental Relief Fund (ERF) - CPCB Dashboard</h2>
  <div class="row g-4">
    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-blue">
            <i class="bi bi-speedometer2"></i>
          </div>
          <div class="icon-circle bg-icon-blue">
            <i class="bi bi-speedometer2"></i>
          </div>
          <div class="dashboard-label">Total Insurance Company Registered</div>
          <div class="dashboard-count fw-bold text-primary">{{ $uniqueUserCount }}</div>
          <div class="dashboard-count fw-bold text-primary">{{ $uniqueUserCount }}</div>
        </div>
        <a href="{{ route('insComplist') }}" class="btn btn-view mt-2">
          <i class="bi bi-eye me-1"></i> View
        </a>
        <a href="{{ route('insComplist') }}" class="btn btn-view mt-2">
          <i class="bi bi-eye me-1"></i> View
        </a>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-green">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <div class="dashboard-label">Total Number of Policy Issued</div>
          <div class="dashboard-count text-warning fw-bold">{{ $totalPolicylist }}</div>
          <div class="icon-circle bg-icon-green">
            <i class="bi bi-bar-chart-line"></i>
          </div>
          <div class="dashboard-label">Total Number of Policy Issued</div>
          <div class="dashboard-count text-warning fw-bold">{{ $totalPolicylist }}</div>
        </div>
        <a href="{{ route('insurance-summary') }}" class="btn btn-view mt-2">
          <i class="bi bi-eye me-1"></i> View
        </a>
        <a href="{{ route('insurance-summary') }}" class="btn btn-view mt-2">
          <i class="bi bi-eye me-1"></i> View
        </a>
      </div>
    </div>

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
        <a href="{{ route('erfcontsummary') }}" class="btn btn-view mt-2">
          <i class="bi bi-eye me-1"></i> View
        </a>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-teal">
            <i class="bi bi-people"></i>
          </div>
          <div class="dashboard-label">Registered Industry</div>
          <div class="dashboard-count">Total: 0</div>
          <div class="icon-circle bg-icon-teal">
            <i class="bi bi-people"></i>
          </div>
          <div class="dashboard-label">Registered Industry</div>
          <div class="dashboard-count">Total: 0</div>
        </div>
        <button class="btn btn-view mt-2">
          <i class="bi bi-eye me-1"></i> View
        </button>
        <button class="btn btn-view mt-2">
          <i class="bi bi-eye me-1"></i> View
        </button>
      </div>
    </div>
  </div>

  {{-- ===============================
       CHARTS SECTION
  ================================ --}}
  <div class="row mt-4 align-items-stretch">
    {{-- Monthly ERF Contribution --}}

  {{-- ===============================
       CHARTS SECTION
  ================================ --}}
  <div class="row mt-4 align-items-stretch">
    {{-- Monthly ERF Contribution --}}
    <div class="col-md-6 mb-4">
      <div class="card p-3 shadow-sm text-center h-100">
        <h5 class="mb-3 text-primary fw-bold">Monthly ERF Contribution</h5>
        <div class="chart-container flex-fill" style="height:350px;">
          <canvas id="monthlyPoliciesChart"></canvas>
        </div>
      </div>
      <div class="card p-3 shadow-sm text-center h-100">
        <h5 class="mb-3 text-primary fw-bold">Monthly ERF Contribution</h5>
        <div class="chart-container flex-fill" style="height:350px;">
          <canvas id="monthlyPoliciesChart"></canvas>
        </div>
      </div>
    </div>

    {{-- ERF by Insurance Company --}}
    <div class="col-md-6 mb-4">
      <div class="card p-3 shadow-sm text-center h-100">
        <h5 class="mb-3 text-primary fw-bold">ERF Contribution by Insurance Company</h5>
        <div class="chart-container flex-fill" style="height:350px;">
          <canvas id="erfChart"></canvas>

    {{-- ERF by Insurance Company --}}
    <div class="col-md-6 mb-4">
      <div class="card p-3 shadow-sm text-center h-100">
        <h5 class="mb-3 text-primary fw-bold">ERF Contribution by Insurance Company</h5>
        <div class="chart-container flex-fill" style="height:350px;">
          <canvas id="erfChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- ===============================
       FULL-WIDTH CHARTS SECTION
  ================================ --}}
  <div class="row">
    <div class="col-12 mb-4">
      <div class="card p-4 shadow-sm h-100">
        <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
          ERF Contribution By Insurance Companies
        </h5>
        <div class="chart-container" style="min-height:400px;">
          <canvas id="industriesByCompanyChart_HBar"></canvas>
        </div>
      </div>
    </div>
      </div>
    </div>
  </div>

  {{-- ===============================
       FULL-WIDTH CHARTS SECTION
  ================================ --}}
  <div class="row">
    <div class="col-12 mb-4">
      <div class="card p-4 shadow-sm h-100">
        <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
          ERF Contribution By Insurance Companies
        </h5>
        <div class="chart-container" style="min-height:400px;">
          <canvas id="industriesByCompanyChart_HBar"></canvas>
        </div>
      </div>
    </div>

    <div class="col-12 mb-4">
      <div class="card p-4 shadow-sm h-100">
        <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
          Industries Insured By Insurance Company
        </h5>
        <div class="chart-container" style="min-height:400px;">
          <canvas id="industriesByCompanyChart_vetical"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- this line of code added by jalaj on 16-09-2025 -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])
<script>
document.addEventListener("DOMContentLoaded", function () {
  console.log("📊 Dashboard Charts Init");
  console.log("📊 Dashboard Charts Init");

  const erfLabels = @json($erfLabels);
  const erfAmounts = @json($erfAmounts).map(Number);
  const months = @json($months);
  const policyCounts = @json($policyCounts).map(Number);
  const policyAmounts = @json($policyAmounts).map(Number);
  const companyLabels = @json($erfLabels);
  const companyIndustries = @json($companyIndustries).map(Number);
  const companyErf = @json($companyErf).map(Number);

  function formatINR(value) {
    if (value >= 10000000) return "₹ " + (value / 10000000).toFixed(1) + " Cr";
    if (value >= 100000) return "₹ " + (value / 100000).toFixed(1) + " L";
    return "₹ " + value.toLocaleString();
  }
  const erfLabels = @json($erfLabels);
  const erfAmounts = @json($erfAmounts).map(Number);
  const months = @json($months);
  const policyCounts = @json($policyCounts).map(Number);
  const policyAmounts = @json($policyAmounts).map(Number);
  const companyLabels = @json($erfLabels);
  const companyIndustries = @json($companyIndustries).map(Number);
  const companyErf = @json($companyErf).map(Number);

  function formatINR(value) {
    if (value >= 10000000) return "₹ " + (value / 10000000).toFixed(1) + " Cr";
    if (value >= 100000) return "₹ " + (value / 100000).toFixed(1) + " L";
    return "₹ " + value.toLocaleString();
  }

   // **** Month-wise policies taken
    const ctx = document.getElementById('monthlyPoliciesChart');
    // Calculate cumulative totals
    let cumulative = [];
    policyAmounts.reduce((a, b, i) => cumulative[i] = a + b, 0);
    new Chart(ctx, {
        data: {
            labels: months,
            datasets: [
                {
                    type: 'bar',
                    label: 'Monthly Contribution',
                    data: policyAmounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderRadius: 6,
                    yAxisID: 'y'
                },
                {
                    type: 'line',
                    label: 'Cumulative Contribution',
                    data: cumulative,
                    borderColor: 'tomato',
                    borderWidth: 2,
                    pointBackgroundColor: 'tomato',
                    fill: false,
                    tension: 0.3,
                    yAxisID: 'y'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 20,
                        padding: 15,
                        maxWidth: 200
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `₹ ${context.formattedValue} L`;
                        }
                    }
                },
                datalabels: {
                    color: 'black',
                    anchor: function(context) {
                        return context.dataset.type === 'bar' ? 'end' : 'center';
                    },
                    align: function(context) {
                        return context.dataset.type === 'bar' ? 'end' : 'top';
                    },
                    formatter: function(value, context) {
                        if (context.dataset.type === 'bar') {
                            return `₹ ${value} L`;
                        }
                        return ''; // hide for line
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Contribution (₹ Lacs)' },
                    ticks: {
                        callback: function(value) {
                            if (value >= 100000) return '₹ ' + (value/100000).toFixed(1) + ' Cr';
                            return '₹ ' + value + ' L';
                        }
                    }
                }
            }
        }
    });
    
  // 1️⃣ Doughnut Chart
  const erfCanvas = document.getElementById("erfChart");
  if (erfCanvas) {
        new Chart(erfCanvas, {
        type: "doughnut",
        data: {
            labels: erfLabels,
            datasets: [{
            data: erfAmounts,
            backgroundColor: [
                "rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)",
                "rgb(75, 192, 192)", "rgb(54, 162, 235)",
                "rgb(153, 102, 255)", "rgb(201, 203, 207)"
            ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                label: ctx => {
                    const value = ctx.raw;
                    const total = ctx.chart._metasets[0].total;
                    const pct = ((value / total) * 100).toFixed(1);
                    return `${ctx.label}: ${formatINR(value)} (${pct}%)`;
                }
                }
            },
            datalabels: {
                color: "#fff",
                font: { weight: "bold", size: 12 },
                formatter: (value, ctx) => {
                const total = ctx.chart._metasets[0].total;
                const pct = (value / total) * 100;
                return pct < 5 ? "" : formatINR(value);
                }
            }
            }
        }
   // **** Month-wise policies taken
    const ctx = document.getElementById('monthlyPoliciesChart');
    // Calculate cumulative totals
    let cumulative = [];
    policyAmounts.reduce((a, b, i) => cumulative[i] = a + b, 0);
    new Chart(ctx, {
        data: {
            labels: months,
            datasets: [
                {
                    type: 'bar',
                    label: 'Monthly Contribution',
                    data: policyAmounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderRadius: 6,
                    yAxisID: 'y'
                },
                {
                    type: 'line',
                    label: 'Cumulative Contribution',
                    data: cumulative,
                    borderColor: 'tomato',
                    borderWidth: 2,
                    pointBackgroundColor: 'tomato',
                    fill: false,
                    tension: 0.3,
                    yAxisID: 'y'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 20,
                        padding: 15,
                        maxWidth: 200
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `₹ ${context.formattedValue} L`;
                        }
                    }
                },
                datalabels: {
                    color: 'black',
                    anchor: function(context) {
                        return context.dataset.type === 'bar' ? 'end' : 'center';
                    },
                    align: function(context) {
                        return context.dataset.type === 'bar' ? 'end' : 'top';
                    },
                    formatter: function(value, context) {
                        if (context.dataset.type === 'bar') {
                            return `₹ ${value} L`;
                        }
                        return ''; // hide for line
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Contribution (₹ Lacs)' },
                    ticks: {
                        callback: function(value) {
                            if (value >= 100000) return '₹ ' + (value/100000).toFixed(1) + ' Cr';
                            return '₹ ' + value + ' L';
                        }
                    }
                }
            }
        }
    });
    
  // 1️⃣ Doughnut Chart
  const erfCanvas = document.getElementById("erfChart");
  if (erfCanvas) {
        new Chart(erfCanvas, {
        type: "doughnut",
        data: {
            labels: erfLabels,
            datasets: [{
            data: erfAmounts,
            backgroundColor: [
                "rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)",
                "rgb(75, 192, 192)", "rgb(54, 162, 235)",
                "rgb(153, 102, 255)", "rgb(201, 203, 207)"
            ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                label: ctx => {
                    const value = ctx.raw;
                    const total = ctx.chart._metasets[0].total;
                    const pct = ((value / total) * 100).toFixed(1);
                    return `${ctx.label}: ${formatINR(value)} (${pct}%)`;
                }
                }
            },
            datalabels: {
                color: "#fff",
                font: { weight: "bold", size: 12 },
                formatter: (value, ctx) => {
                const total = ctx.chart._metasets[0].total;
                const pct = (value / total) * 100;
                return pct < 5 ? "" : formatINR(value);
                }
            }
            }
        }
        });
    }
    }

    // 3️⃣ Industries by Company (Horizontal)
    //new Chart(document.getElementById('industriesByCompanyChart_polerArea'), {
    new Chart(document.getElementById('industriesByCompanyChart_HBar'), {
        type: 'bar',   // stays 'bar', just flip axis
        data: {
            labels: companyLabels,   // Insurance Companies
            datasets: [{
            label: 'ERF Contribution',
            data: erfAmounts,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 205, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(201, 203, 207, 0.5)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
            }]
        },
        options: {
        indexAxis: 'y',   // ✅ makes it horizontal
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
            left: 50   // ✅ add space so long company names don't get hidden
            }
        },
        scales: {
            x: {   // horizontal axis = values
            beginAtZero: true,
            title: {
                display: true,
                text: 'ERF Contribution (in Lakhs)',
                color: '#084095',
                font: { weight: 'bold', size: 14 }
            },
            ticks: {
                callback: value => formatINR(value)
            }
            },
            y: {   // vertical axis = company names
            title: {
                display: true,
                text: 'Insurance Companies',
                color: '#084095',
                font: { weight: 'bold', size: 14 }
            },
            ticks: {
                autoSkip: false   // show all companies
            }
            }
        },
        plugins: {
            legend: { display: false },
            datalabels: {
            anchor: 'end',
            align: 'right',   // ✅ place values at end of bars
            color: '#000',
            font: { weight: 'bold', size: 11 },
            formatter: value => formatINR(value)
            }
        }
        }
    });
   
    //this is vertcal bar graph
    new Chart(document.getElementById('industriesByCompanyChart_vetical'), {
        type: 'bar',   // ✅ vertical bar chart
        data: {
            labels: companyLabels,   // 👈 X-axis: Insurance Companies
            datasets: [{
                label: 'Industries Insured',
                data: companyIndustries,   // 👈 Y-axis values: number of industries
                backgroundColor: [
                    'rgba(173, 216, 230, 0.6)', // light blue
                    'rgba(135, 206, 235, 0.6)', // sky blue
                    'rgba(176, 196, 222, 0.6)', // light steel blue
                    'rgba(100, 149, 237, 0.6)', // cornflower blue
                    'rgba(70, 130, 180, 0.6)',  // steel blue
                    'rgba(176, 224, 230, 0.6)', // powder blue
                    'rgba(0, 191, 255, 0.6)'    // deep sky blue
                ],
                borderColor: [
                    'rgba(173, 216, 230, 1)',
                    'rgba(135, 206, 235, 1)',
                    'rgba(176, 196, 222, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(70, 130, 180, 1)',
                    'rgba(176, 224, 230, 1)',
                    'rgba(0, 191, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {   // ✅ industries count on Y-axis
                    beginAtZero: true,
                    grace: '20%',
                    title: {
                        display: true,
                        text: 'Number of Industries',
                        color: '#084095',
                        font: { weight: 'bold', size: 14 }
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {   // ✅ company names on X-axis
                    title: {
                        display: true,
                        text: 'Insurance Companies',
                        color: '#084095',
                        font: { weight: 'bold', size: 14 }
                    },
                    ticks: {
                        autoSkip: false   // show all company names
                    }
                }
            },
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',   // ✅ show labels above bars
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 11
                    },
                    formatter: function(value) {
                        return value; // ✅ show industry count on top
                    }
                }
            }
        }
    });
  console.log("✅ Charts Rendered Successfully");
    // 3️⃣ Industries by Company (Horizontal)
    //new Chart(document.getElementById('industriesByCompanyChart_polerArea'), {
    new Chart(document.getElementById('industriesByCompanyChart_HBar'), {
        type: 'bar',   // stays 'bar', just flip axis
        data: {
            labels: companyLabels,   // Insurance Companies
            datasets: [{
            label: 'ERF Contribution',
            data: erfAmounts,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 205, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(201, 203, 207, 0.5)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
            }]
        },
        options: {
        indexAxis: 'y',   // ✅ makes it horizontal
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
            left: 50   // ✅ add space so long company names don't get hidden
            }
        },
        scales: {
            x: {   // horizontal axis = values
            beginAtZero: true,
            title: {
                display: true,
                text: 'ERF Contribution (in Lakhs)',
                color: '#084095',
                font: { weight: 'bold', size: 14 }
            },
            ticks: {
                callback: value => formatINR(value)
            }
            },
            y: {   // vertical axis = company names
            title: {
                display: true,
                text: 'Insurance Companies',
                color: '#084095',
                font: { weight: 'bold', size: 14 }
            },
            ticks: {
                autoSkip: false   // show all companies
            }
            }
        },
        plugins: {
            legend: { display: false },
            datalabels: {
            anchor: 'end',
            align: 'right',   // ✅ place values at end of bars
            color: '#000',
            font: { weight: 'bold', size: 11 },
            formatter: value => formatINR(value)
            }
        }
        }
    });
   
    //this is vertcal bar graph
    new Chart(document.getElementById('industriesByCompanyChart_vetical'), {
        type: 'bar',   // ✅ vertical bar chart
        data: {
            labels: companyLabels,   // 👈 X-axis: Insurance Companies
            datasets: [{
                label: 'Industries Insured',
                data: companyIndustries,   // 👈 Y-axis values: number of industries
                backgroundColor: [
                    'rgba(173, 216, 230, 0.6)', // light blue
                    'rgba(135, 206, 235, 0.6)', // sky blue
                    'rgba(176, 196, 222, 0.6)', // light steel blue
                    'rgba(100, 149, 237, 0.6)', // cornflower blue
                    'rgba(70, 130, 180, 0.6)',  // steel blue
                    'rgba(176, 224, 230, 0.6)', // powder blue
                    'rgba(0, 191, 255, 0.6)'    // deep sky blue
                ],
                borderColor: [
                    'rgba(173, 216, 230, 1)',
                    'rgba(135, 206, 235, 1)',
                    'rgba(176, 196, 222, 1)',
                    'rgba(100, 149, 237, 1)',
                    'rgba(70, 130, 180, 1)',
                    'rgba(176, 224, 230, 1)',
                    'rgba(0, 191, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {   // ✅ industries count on Y-axis
                    beginAtZero: true,
                    grace: '20%',
                    title: {
                        display: true,
                        text: 'Number of Industries',
                        color: '#084095',
                        font: { weight: 'bold', size: 14 }
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {   // ✅ company names on X-axis
                    title: {
                        display: true,
                        text: 'Insurance Companies',
                        color: '#084095',
                        font: { weight: 'bold', size: 14 }
                    },
                    ticks: {
                        autoSkip: false   // show all company names
                    }
                }
            },
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',   // ✅ show labels above bars
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 11
                    },
                    formatter: function(value) {
                        return value; // ✅ show industry count on top
                    }
                }
            }
        }
    });
  console.log("✅ Charts Rendered Successfully");
});
</script>
@endsection


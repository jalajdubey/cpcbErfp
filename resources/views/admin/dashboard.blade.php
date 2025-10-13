<style>

    /* Base styles */
    body {
      background-color: #f8f9fc;
      font-family: 'Segoe UI', sans-serif;
    }

    /* Title */
    .dashboard-title {
      text-align: center;
      color: #084095;
      font-size: 1.75rem;
      font-weight: 700;
      margin-bottom: 2.5rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

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
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">


@include('layouts.sidebar')
@include('layouts.top-navbar')

  <div class="main-panel">
  
    <div class="card mt-3">
    
    <h2 class="dashboard-title">Environmental Relief Fund (ERF) - CPCB Dashboard</h2>
  <div class="row g-4">

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-blue"><i class="bi bi-speedometer2"></i></div>
          <div class="dashboard-label">Total Insurance Company Registered</div>
          <div class="dashboard-count" style="color:#0d6efd;font-weight:bold">{{$uniqueUserCount}}</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> 
        <a href="{{ route('insComplist') }}">View</a>
        </button>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-green"><i class="bi bi-bar-chart-line"></i></div>
          <div class="dashboard-label">Total Number of Policy Issued By Insurance Company </div>
          <div class="dashboard-count" style="color:orange;font-weight:bold">Total: {{ $totalPolicylist }}</div>
        </div>
        <button class="btn btn-view mt-2">
          
          <i class="bi bi-eye me-1"></i> 
          <a href="{{ route('insurance-summary') }}"> 
          View</a></button>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-orange"><i class="bi bi-ui-checks-grid"></i></div>
          <div class="dashboard-label">Total Contribution of ERF fund in Rs</div>
          <div class="dashboard-count" style="color:#198754;font-weight:bold">Total:Rs. {{format_inr($totalContribution, 2)}} </div>
        </div> 
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i>
         <a href="{{ route('erfcontsummary') }}"> 
        View</a>
      </button>
      </div>
    </div>

    <!-- <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-red"><i class="bi bi-table"></i></div>
          <div class="dashboard-label">Beneficiary List</div>
          <div class="dashboard-count">Total: 120</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div> -->

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-teal"><i class="bi bi-people"></i></div>
          <div class="dashboard-label">Registered Industry</div>
          <div class="dashboard-count">Total: 0</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div>

    <!-- <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-yellow"><i class="bi bi-calendar-event"></i></div>
          <div class="dashboard-label">Event Calendar</div>
          <div class="dashboard-count">Upcoming: 5</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-gray"><i class="bi bi-pie-chart-fill"></i></div>
          <div class="dashboard-label">Fund Allocation</div>
          <div class="dashboard-count">₹12.5 Cr</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-indigo"><i class="bi bi-file-earmark-text"></i></div>
          <div class="dashboard-label">Policy Documents</div>
          <div class="dashboard-count">Total: 18</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div> -->

  </div>
 </div>
   <div class="row mt-4">
      <!-- monthly contribution Chart -->
     <!-- Monthly Contribution Chart -->
    <div class="col-md-6 mb-4">
        <div class="card p-3 shadow-sm text-center">
            <h5 class="mb-3" style="color:#084095; font-weight:bold;">
                Monthly ERF Contribution
            </h5>
            <div style="height:400px;">
                <canvas id="monthlyPoliciesChart"></canvas>
            </div>
        </div>
    </div>
    <!-- Pie Chart -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm text-center">
                <h5 class="mb-3" style="color:#084095; font-weight:bold;">
                    ERF Contribution by Insurance Company
                </h5>
                <div style="height:400px; margin:auto;">
                    <canvas id="erfChart"></canvas>
                </div>
                <!-- <div style="margin-top:15px; font-weight:bold; color:#084095;">
                    Total ERF: ₹ {{ number_format($erfTotal, 2) }}
                </div> -->
            </div>
        </div>
    <!-- Bar chart -->
    <div class="card p-4 shadow-sm mt-4">
            <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
                Insurance Companies Vs.  Industry Count
            </h5>
            <div style="height:400px;">
                <canvas id="industriesByCompanyChart"></canvas>
            </div>
        </div>

        
         <!-- poler are chart -->
      <div class="card p-4 shadow-sm mt-4">
              <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
                  ERF Contribution By Insurance Companies
              </h5>
              <div style="height:400px;">
                  <canvas id="industriesByCompanyChart_HBar"></canvas>
              </div>
          </div>

             <!-- poler are chart -->
      <div class="card p-4 shadow-sm mt-4">
              <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
                  Industries Insured By Insurance Company 
              </h5>
              <div style="height:400px;">
                  <canvas id="industriesByCompanyChart_vetical"></canvas>
              </div>
          </div>

      
</div>
</div>
<!-- this line of code added by jalaj on 16-09-2025 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const envColors = [
    '#2e7d32', // forest green
    '#388e3c', // medium green
    '#43a047', // bright green
    '#66bb6a', // light green
    '#81c784', // softer green
    '#4caf50', // standard green
    '#1b5e20', // deep forest
    '#2e86c1', // eco blue
    '#5dade2', // light blue
    '#a3e4d7', // aqua/teal
    '#f4d03f', // sunlight yellow
    '#f39c12'  // earthy orange
];
document.addEventListener("DOMContentLoaded", function () {

        // ---- doughnut Chart ----
        const erfLabels = @json($erfLabels);
        const erfAmounts = @json($erfAmounts);
        // 🔹 Helper: Format INR to Cr/L
        function formatINR(value) {
            if (value >= 10000000) {
                return '₹ ' + (value / 10000000).toFixed(1) + ' Cr';
            } else if (value >= 100000) {
                return '₹ ' + (value / 100000).toFixed(1) + ' L';
            }
            return '₹ ' + value.toLocaleString();
        }

        new Chart(document.getElementById('erfChart'), {
            type: 'doughnut',
            data: {
                labels: erfLabels,
               datasets: [{
                    data: erfAmounts,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                  'rgb(255, 159, 64)',
                  'rgb(255, 205, 86)',
                  'rgb(75, 192, 192)',
                  'rgb(54, 162, 235)',
                  'rgb(153, 102, 255)',
                  'rgb(201, 203, 207)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }, // ✅ remove right-side legend
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                let total = context.chart._metasets[0].total;
                                let percentage = ((value / total) * 100).toFixed(1);
                                return context.label + ': ' + formatINR(value) + ' (' + percentage + '%)';
                            }
                        }
                    },
                    datalabels: {
                        color: function(ctx) {
                            // auto contrast: white on dark slices, black on light ones
                            let bgColor = ctx.dataset.backgroundColor[ctx.dataIndex];
                            return (['#ffc107', '#f8f9fa'].includes(bgColor)) ? '#000' : '#fff';
                        },
                        font: {
                            weight: 'bold',
                            size: 12
                        },
                       formatter: function(value, ctx) {
                            let total = ctx.chart._metasets[0].total;
                            let percentage = (value / total) * 100;

                            if (percentage < 5) {
                                // show short form like ₹10k
                                //return '₹ ' + (value / 1000).toFixed(0) + 'k';
                                  return ''; // ✅ hide small slice labels
                            }
                            return formatINR(value);
                        }
                    }
                }
            }
        });

         // **** Month-wise policies taken
        const ctx = document.getElementById('monthlyPoliciesChart');
        const months = @json($months);
        const policyCounts = @json($policyCounts);
        const policyAmounts = @json($policyAmounts); // in Lacs

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

//****insurance companies coverd industryCount
        const companyLabels = @json($erfLabels);
        const companyIndustries = @json($companyIndustries);
        const companyErf = @json($companyErf);

        function formatINR(value) {
            return '₹ ' + (value / 100000).toFixed(1) + ' L';
        }

        new Chart(document.getElementById('industriesByCompanyChart'), {
            type: 'bar',
            data: {
                labels: companyLabels,   // 👈 Y-axis: Insurance Companies
                datasets: [{
                    label: 'Industries Insured',
                    data: companyIndustries,   // 👈 X-axis values: number of industries
                    backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 205, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(201, 203, 207, 0.2)'
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
                indexAxis: 'y',   // 👈 horizontal bar chart
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                padding: {
                left: 50   // ✅ add space so long company names don't get hidden
                }
            },
                scales: {
                    x: {
                        beginAtZero: true,
                        grace: '20%',   // 👈 extra space for labels
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
                    y: {
                        title: {
                            display: true,
                            text: 'Insurance Companies',
                            color: '#084095',
                            font: { weight: 'bold', size: 14 }
                        },
                        ticks: {
                            autoSkip: false   // 👈 show all company names
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'right',   // 👈 push labels outside
                        clip: false,
                        color: '#000',
                         font: { weight: 'bold', size: 11 },
        formatter: function(value) {
          return value;   // 👈 show industries insured, not ERF
        }
                    }
                }
            }
        });


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



});
</script>












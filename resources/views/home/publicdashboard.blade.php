@extends('layouts.app')

@section('title', 'Industry Registration')
@section('body-class', 'industry-register-page')

@section('content')

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
<<<<<<< Updated upstream

@include('home.footer')

@vite(['resources/css/app.css', 'resources/js/app.js'])
=======
>>>>>>> Stashed changes
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
        // ---- Bar Chart ----
        const erfLabels = @json($erfLabels);
        const labels = @json($companyLabels);
        const companyLabels = @json($erfLabels);
        const industryCounts = @json($industryCounts);
        new Chart(document.getElementById('policyChart'), {
        type: 'bar',
        data: {
            labels: erfLabels,
            datasets: [{
            label: 'Industries Insured',
            data: industryCounts,
            backgroundColor: [
                '#4e79a7', '#59a14f', '#f28e2b', '#e15759',
                '#76b7b2', '#edc948', '#b07aa1', '#9c755f', '#bab0ac'
            ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
            padding: {
            top: 20   // give space for labels above tallest bar
                }
            },
            plugins: {
            legend: { display: false },
            datalabels: {
                anchor: 'end',       // position relative to bar
                align: 'top',
                offset: 2,        // show above the bar
                color: '#000',       // text color
                font: {
                weight: 'bold'
                },
                formatter: (value) => value // show raw count
            }
            },
            scales: {
            x: {
                title: {
                display: true,
                text: 'Insurance Companies'
                },
                ticks: {
                stepSize: 1,
                precision: 0
                }
            },
            y: {
                title: {
                display: true,
                text: 'Number of Industries Insured'
                },
                beginAtZero: true,
                ticks: {
                stepSize: 1,
                precision: 0
                }
            }
            }
        }
        });

<<<<<<< Updated upstream
        // ---- Pie Chart ----
       
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
            type: 'pie',
            data: {
                labels: erfLabels,
               datasets: [{
                    data: erfAmounts,
                    backgroundColor: [
                        '#4e79a7', '#59a14f', '#f28e2b', '#e15759',
                        '#76b7b2', '#edc948', '#b07aa1', '#9c755f', '#bab0ac'
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

        //****insurance companies coverd industryCount
        
        const companyIndustries = @json($companyIndustries);
        const companyErf = @json($companyErf);

        function formatINR(value) {
            return '₹ ' + (value / 100000).toFixed(1) + ' L';
        }

        new Chart(document.getElementById('industriesByCompanyChart'), {
            type: 'bar',
            data: {
                labels: erfLabels,   // 👈 Y-axis: Insurance Companies
                datasets: [{
                    label: 'Industries Insured',
                    data: industryCounts,   // 👈 X-axis values: number of industries
                    backgroundColor: envColors
                }]
            },
            options: {
                indexAxis: 'y',   // 👈 horizontal bar chart
                responsive: true,
                maintainAspectRatio: false,
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
                        font: {
                            weight: 'bold',
                            size: 11
                        },
                        formatter: function(value, ctx) {
                            return formatINR(erfAmounts[ctx.dataIndex]); // 👈 ERF contribution shown
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

        new Chart(ctx, {
  type: 'bar',
  data: {
    labels: months,
    datasets: [
      {
        type: 'bar',
        label: 'Policies Taken',
        data: policyCounts,
        backgroundColor: 'rgba(75, 192, 192, 0.6)',
        yAxisID: 'y',
        barPercentage: 1.0,
        categoryPercentage: 1.0,
        datalabels: {          // ✅ apply only to this dataset
          anchor: 'end',
          align: 'top',
          offset: 2,
          color: '#000',
          font: { weight: 'bold' },
          formatter: (value) => value
        }
      },
      {
        type: 'line',
        label: 'Policy Trend',
        data: policyCounts,
        borderColor: 'blue',
        borderWidth: 2,
        fill: false,
        tension: 0.3,
        pointBackgroundColor: 'blue',
        yAxisID: 'y',
        datalabels: { display: false }  // ❌ no labels for line
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        title: {
          display: true,
          text: 'Policies Taken'
        }
      }
    },
    plugins: {
      tooltip: {
        callbacks: {
          label: function (context) {
            if (context.dataset.type === 'line') {
              const index = context.dataIndex;
              return [
                'Policies: ' + policyCounts[index],
                'Amount: ' + policyAmounts[index] + ' L'
              ];
            }
            return null;
          }
        }
      },
      legend: {
        labels: {
          filter: function (item) {
            return item.text !== 'Policy Trend'; // hide trend label if unwanted
          }
        }
      }
    }
  }
  
});

});
</script>
=======
@endsection
>>>>>>> Stashed changes

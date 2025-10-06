@include('home.header')

<div class="container-fluid mt-4 mb-5">
    <div class="container">
        <h2 class="text-center mb-4" style="color:#084095; font-weight:bold;">
            Public Dashboard – ERF
        </h2>

      <div class="card p-4 shadow-sm mt-4">
                    <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
                        ERF Contribution Treemap (Insurance Companies)
                    </h5>
                    <div style="height:500px;">
                        <canvas id="erfTreemap"></canvas>
                    </div>
                </div>

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

            <div class="card p-4 shadow-sm mt-4">
            <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
                Industries Insured vs ERF Contribution (by Company)
            </h5>
            <div style="height:400px;">
                <canvas id="industriesByCompanyChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart -->
            <div class="col-md-6 mb-4">
                <div class="card p-3 shadow-sm">
                    <h5 class="text-center mb-3" style="color:#084095; font-weight:bold;">
                        Industries Insured per Insurance Company
                    </h5>
                    <div style="height:300px;">
                        <canvas id="policyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
           <div class="col-md-6 mb-4">
                <div class="card p-3 shadow-sm text-center">
                    <h5 class="mb-3" style="color:#084095; font-weight:bold;">
                        ERF Contribution by Insurance Company
                    </h5>
                    <div style="max-width:350px; margin:auto;">
                        <canvas id="erfChart"></canvas>
                    </div>
                    <div style="margin-top:15px; font-weight:bold; color:#084095;">
                        Total ERF: ₹ {{ number_format($erfTotal, 2) }}
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

@vite(['resources/css/app.css', 'resources/js/app.js'])
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
    const labels = @json($labels);
    const industryCounts = @json($industryCounts);
    new Chart(document.getElementById('policyChart'), {
        type: 'bar',
        data: {
            labels: labels,
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
            plugins: {
                legend: { display: false },
                datalabels: { display: false } // ✅ no text inside bars
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });

    // ---- Pie Chart ----
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
                        '#4e79a7', '#59a14f', '#f28e2b', '#e15759',
                        '#76b7b2', '#edc948', '#b07aa1', '#9c755f', '#bab0ac'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' },
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
                                return '₹ ' + (value / 1000).toFixed(0) + 'k';
                            }
                            return formatINR(value);
                        }
                    }
                }
            }
        });

        //insurance companies coverd industryCoun
        //const companyLabels = @json($companyLabels);
        const companyLabels = @json($erfLabels);
        
        const companyIndustries = @json($companyIndustries);
        const companyErf = @json($companyErf);

       function formatINR(value) {
        return '₹ ' + (value / 100000).toFixed(1) + ' L';
         }
        new Chart(document.getElementById('industriesByCompanyChart'), {
            type: 'bar',
            data: {
                labels: companyLabels,
                datasets: [{
                    label: 'Industries Insured',
                    data: companyIndustries,
                    backgroundColor: envColors
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            callback: function(value) {
                                let next = value + 10;
                                return value + '–' + next;
                            }
                        }
                    },
                    y: {
                        ticks: { autoSkip: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        clip: false,
                        color: '#000',
                        font: {
                            weight: 'bold',
                            size: 11
                        },
                        formatter: function(value, ctx) {
                            return formatINR(companyErf[ctx.dataIndex]);
                        }
                    }
                }
            }
        });

     // ---- Treemap Chart ----
const treemapLabels = @json($erfLabels);    // company names
const treemapValues = @json($erfAmounts);   // contributions

// Build data, filter out null/0 values
const treemapData = treemapLabels.map((name, i) => {
    let safeName = name ?? "Unknown";
    let value = treemapValues[i] ?? 0;

    return {
        label: safeName,
        shortLabel: safeName.split(" ").map(w => w[0]).join("").toUpperCase(), // Short code
        value: value
    };
}).filter(item => item.value > 0);   // ✅ remove zero-contribution

// Format INR only in Lakhs
function formatINRT(value) {
    if (!value || isNaN(value)) return '₹ 0';
    return '₹ ' + (value / 100000).toFixed(1) + ' L';
}

new Chart(document.getElementById('erfTreemap'), {
    type: 'treemap',
    data: {
        datasets: [{
            tree: treemapData,
            key: 'value',
            groups: ['label'],
            borderColor: '#fff',
            borderWidth: 1,
            spacing: 0.5,
            backgroundColor(ctx) {
                const colors = [
                    '#4e79a7','#59a14f','#f28e2b','#e15759',
                    '#76b7b2','#edc948','#b07aa1','#9c755f','#bab0ac'
                ];
                return colors[ctx.index % colors.length];
            },
            labels: {
                display: true,
                formatter(ctx) {
                    const item = ctx.raw;
                    // Show only short code inside the box
                    return item.shortLabel;
                },
                font: {
                    size: 12,
                    weight: 'bold'
                },
                color: 'white',  // ✅ all text white
                align: 'center'
            }
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let item = context.raw;
                        let total = treemapData.reduce((a, b) => a + (b.value || 0), 0);
                        if (total === 0) return item.label + ': ₹ 0 (0%)'; // ✅ avoid NaN
                        let percentage = ((item.value / total) * 100).toFixed(1);
                        // ✅ Tooltip shows full company name + contribution in Lakhs
                        return item.label + ': ' + formatINRT(item.value) + ' (' + percentage + '%)';
                    }
                }
            },
            legend: { display: false }
        }
    }
});


});
</script>

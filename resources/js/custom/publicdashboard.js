$(function () {
  console.log("✅ Public Dashboard JS loaded");

  const envColors = [
    "#2e7d32", "#388e3c", "#43a047", "#66bb6a", "#81c784", "#4caf50",
    "#1b5e20", "#2e86c1", "#5dade2", "#a3e4d7", "#f4d03f", "#f39c12"
  ];

  // --- Helpers ---
  const formatINR = (value) => {
    if (value >= 10000000) return "₹ " + (value / 10000000).toFixed(1) + " Cr";
    if (value >= 100000) return "₹ " + (value / 100000).toFixed(1) + " L";
    return "₹ " + value.toLocaleString();
  };

  // --- Data from Blade ---
  const erfLabels = window.erfLabels;
  const erfAmounts = window.erfAmounts;
  const industryCounts = window.industryCounts;
  const months = window.months;
  const policyCounts = window.policyCounts;
  const policyAmounts = window.policyAmounts;

  // --- Bar Chart: Industries Insured per Insurance Company ---
  if ($("#policyChart").length && window.Chart) {
    new Chart(document.getElementById("policyChart"), {
      type: "bar",
      data: {
        labels: erfLabels,
        datasets: [{
          label: "Industries Insured",
          data: industryCounts,
          backgroundColor: [
            "#4e79a7", "#59a14f", "#f28e2b", "#e15759",
            "#76b7b2", "#edc948", "#b07aa1", "#9c755f", "#bab0ac"
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          datalabels: {
            anchor: "end",
            align: "top",
            color: "#000",
            font: { weight: "bold" },
            formatter: (value) => value
          }
        },
        scales: {
          x: { title: { display: true, text: "Insurance Companies" } },
          y: { title: { display: true, text: "Number of Industries" }, beginAtZero: true }
        }
      }
    });
  }

  // --- Pie Chart: ERF Contribution ---
  if ($("#erfChart").length && window.Chart) {
    new Chart(document.getElementById("erfChart"), {
      type: "pie",
      data: {
        labels: erfLabels,
        datasets: [{
          data: erfAmounts,
          backgroundColor: [
            "#4e79a7", "#59a14f", "#f28e2b", "#e15759",
            "#76b7b2", "#edc948", "#b07aa1", "#9c755f", "#bab0ac"
          ]
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (ctx) => {
                let value = ctx.raw;
                let total = ctx.chart._metasets[0].total;
                let pct = ((value / total) * 100).toFixed(1);
                return `${ctx.label}: ${formatINR(value)} (${pct}%)`;
              }
            }
          },
          datalabels: {
            color: "#fff",
            font: { weight: "bold", size: 12 },
            formatter: (value, ctx) => {
              let total = ctx.chart._metasets[0].total;
              let pct = (value / total) * 100;
              return pct < 5 ? "" : formatINR(value);
            }
          }
        }
      }
    });
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

  // --- Monthly Policies Chart ---
  if ($("#monthlyPoliciesChart").length && window.Chart) {
    const ctx = document.getElementById("monthlyPoliciesChart");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: months,
        datasets: [
          {
            type: "bar",
            label: "Policies Taken",
            data: policyCounts,
            backgroundColor: "rgba(75, 192, 192, 0.6)",
            yAxisID: "y"
          },
          {
            type: "line",
            label: "Policy Trend",
            data: policyCounts,
            borderColor: "blue",
            borderWidth: 2,
            fill: false,
            tension: 0.3,
            yAxisID: "y"
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { title: { display: true, text: "Policies Taken" } } },
        plugins: { legend: { display: false } }
      }
    });
  }
});

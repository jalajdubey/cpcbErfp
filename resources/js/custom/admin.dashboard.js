console.log("📊 Admin Dashboard Loaded");

// ====================================================
// ✅ Ensure Chart.js + Datalabels available
// ====================================================
const Chart = window.Chart;
const ChartDataLabels = window.ChartDataLabels || null;
if (Chart && ChartDataLabels) {
  Chart.register(ChartDataLabels);
} else {
  console.warn("⚠️ Chart.js or ChartDataLabels missing — retrying after load");
}

// ====================================================
// ✅ Safe Data Extraction from Blade
// ====================================================
const data = window.dashboardData || {};
const erfLabels = data.erfLabels || [];
const erfAmounts = (data.erfAmounts || []).map(Number);
const months = data.months || [];
const policyCounts = (data.policyCounts || []).map(Number);
const policyAmounts = (data.policyAmounts || []).map(Number);
const companyLabels = data.companyLabels || [];
const companyIndustries = (data.companyIndustries || []).map(Number);
const companyErf = (data.companyErf || []).map(Number);

// ====================================================
// ✅ INR Formatter
// ====================================================
function formatINR(value) {
  if (isNaN(value)) return value;
  if (value >= 10000000) return "₹ " + (value / 10000000).toFixed(1) + " Cr";
  if (value >= 100000) return "₹ " + (value / 100000).toFixed(1) + " L";
  return "₹ " + value.toLocaleString();
}

// ====================================================
// ✅ Data Check
// ====================================================
if (!months.length || !policyAmounts.length) {
  console.warn("⚠️ No chart data found in dashboardData");
} else {
  console.log("✅ Chart data loaded successfully");
}

// ====================================================
// ✅ Chart Initialization (safe load + delay)
// ====================================================
window.addEventListener("load", () => {
  console.log("🌐 Window fully loaded → initializing charts...");

  const waitForCanvas = (id, timeout = 2000) =>
    new Promise((resolve, reject) => {
      const start = Date.now();
      const check = setInterval(() => {
        const el = document.getElementById(id);
        if (el) {
          clearInterval(check);
          resolve(el);
        } else if (Date.now() - start > timeout) {
          clearInterval(check);
          reject(`⏳ Canvas ${id} not found within ${timeout}ms`);
        }
      }, 100);
    });

  // ===============================
  // 1️⃣ Monthly ERF Contribution Chart
  // ===============================
  waitForCanvas("monthlyPoliciesChart")
    .then((ctx) => {
      console.log("🧠 Creating chart:", ctx.id);
      const cumulative = [];
      policyAmounts.reduce((a, b, i) => (cumulative[i] = a + b), 0);

      new Chart(ctx, {
        data: {
          labels: months,
          datasets: [
            {
              type: "bar",
              label: "Monthly Contribution",
              data: policyAmounts,
              backgroundColor: "rgba(54, 162, 235, 0.7)",
              borderRadius: 6,
              yAxisID: "y",
            },
            {
              type: "line",
              label: "Cumulative Contribution",
              data: cumulative,
              borderColor: "tomato",
              borderWidth: 2,
              pointBackgroundColor: "tomato",
              fill: false,
              tension: 0.3,
              yAxisID: "y",
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: "top" },
            datalabels: {
              color: "black",
              anchor: (ctx) =>
                ctx.dataset.type === "bar" ? "end" : "center",
              align: (ctx) =>
                ctx.dataset.type === "bar" ? "end" : "top",
              formatter: (value, ctx) =>
                ctx.dataset.type === "bar" ? `₹ ${value} L` : "",
            },
          },
          scales: {
            y: {
              beginAtZero: true,
              title: { display: true, text: "Contribution (₹ Lacs)" },
            },
          },
        },
      });
    })
    .catch(console.warn);

  // ===============================
  // 2️⃣ Doughnut Chart – ERF Contribution by Company
  // ===============================
  waitForCanvas("erfChart")
    .then((erfCtx) => {
      console.log("🧠 Creating chart:", erfCtx.id);
      new Chart(erfCtx, {
        type: "doughnut",
        data: {
          labels: erfLabels,
          datasets: [
            {
              data: erfAmounts,
              backgroundColor: [
                "rgb(255, 99, 132)",
                "rgb(255, 159, 64)",
                "rgb(255, 205, 86)",
                "rgb(75, 192, 192)",
                "rgb(54, 162, 235)",
                "rgb(153, 102, 255)",
                "rgb(201, 203, 207)",
              ],
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: (ctx) => {
                  const value = ctx.raw;
                  const total = ctx.chart._metasets[0].total;
                  const pct = ((value / total) * 100).toFixed(1);
                  return `${ctx.label}: ${formatINR(value)} (${pct}%)`;
                },
              },
            },
            datalabels: {
              color: "#fff",
              font: { weight: "bold", size: 12 },
              formatter: (value, ctx) => {
                const total = ctx.chart._metasets[0].total;
                const pct = (value / total) * 100;
                return pct < 5 ? "" : formatINR(value);
              },
            },
          },
        },
      });
    })
    .catch(console.warn);

  // ===============================
  // 3️⃣ Bar Chart – Industry Count per Company
  // ===============================
  waitForCanvas("industriesByCompanyChart")
    .then((industryCtx) => {
      console.log("🧠 Creating chart:", industryCtx.id);
      new Chart(industryCtx, {
        type: "bar",
        data: {
          labels: companyLabels,
          datasets: [
            {
              label: "Industries Insured",
              data: companyIndustries,
              backgroundColor: "rgba(54, 162, 235, 0.6)",
              borderColor: "rgb(54, 162, 235)",
              borderWidth: 1,
            },
            {
              label: "ERF Contribution (₹)",
              data: companyErf,
              backgroundColor: "rgba(255, 99, 132, 0.6)",
              borderColor: "rgb(255, 99, 132)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          indexAxis: "y",
          scales: {
            x: { beginAtZero: true },
          },
          plugins: {
            legend: { display: true, position: "top" },
            datalabels: {
              anchor: "end",
              align: "right",
              color: "#000",
              font: { weight: "bold", size: 11 },
            },
          },
        },
      });
    })
    .catch(console.warn);

  // ====================================================
  // ✅ Force resize after layout animations (KaiAdmin)
  // ====================================================
  setTimeout(() => {
    if (window.Chart && window.Chart.instances) {
      Object.values(window.Chart.instances).forEach((chart) => {
        try {
          chart.resize();
        } catch (e) {}
      });
      console.log("🔄 Charts resized after layout load");
    }
  }, 800);
});

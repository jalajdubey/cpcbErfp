
/**
 * ============================================================
 * KaiAdmin-Lite | Logged-In Dashboard Entrypoint (Vite)
 * ============================================================
 * ✅ Loads jQuery first (global window.$)
 * ✅ Loads Bootstrap (bundle)
 * ✅ Initializes KaiAdmin core + settings
 * ✅ Registers Chart.js + plugins
 * ✅ Handles sidebar + navbar toggle
 * ✅ Supports role-based dashboard modules
 * ✅ Optional: SweetAlert2, CryptoJS (global)
 */

// ─────────────────────────────
// 1️⃣ Load jQuery and expose globally
// ─────────────────────────────
import jQuery from "jquery";
window.$ = window.jQuery = jQuery;
console.log("✅ jQuery attached globally (v" + $.fn.jquery + ")");

import "jquery-validation";
console.log("✅ jQuery Validation ready:", typeof $.fn.validate);

// ─────────────────────────────
// 2️⃣ SweetAlert2 + CryptoJS (optional global utils)
// ─────────────────────────────
import Swal from "sweetalert2";
import CryptoJS from "crypto-js";
window.Swal = Swal;
window.CryptoJS = CryptoJS;
console.log("✅ SweetAlert2 & CryptoJS available globally");

// ─────────────────────────────
// 3️⃣ CSRF Setup (Laravel standard)
// ─────────────────────────────
$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN":
      document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "",
  },
});
console.log(
  "✅ CSRF token set:",
  document.querySelector('meta[name="csrf-token"]')?.getAttribute("content")
);

// ─────────────────────────────
// 4️⃣ Load Bootstrap + expose globally
// ─────────────────────────────
import * as bootstrap from "bootstrap";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
window.bootstrap = bootstrap;
console.log("✅ Bootstrap attached globally");

// Reinit dropdowns when DOM changes (KaiAdmin menus etc.)
document.addEventListener("DOMContentLoaded", () => {
  const dropdownTriggers = document.querySelectorAll('[data-bs-toggle="dropdown"]');
  dropdownTriggers.forEach(trigger => {
    const dd = bootstrap.Dropdown.getOrCreateInstance(trigger);
    trigger.addEventListener("click", e => {
      e.preventDefault();
      e.stopPropagation();
      dd.toggle();
    });
  });
});

window.addEventListener("kaiadmin:ready", () => {
  const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
  dropdowns.forEach(el => bootstrap.Dropdown.getOrCreateInstance(el));
});

// ─────────────────────────────
// 5️⃣ Load KaiAdmin core JS (after jQuery ready)
// ─────────────────────────────
(async () => {
  await new Promise(resolve => {
    const check = setInterval(() => {
      if (window.$ && typeof window.$ === "function") {
        clearInterval(check);
        resolve();
      }
    }, 50);
  });

  console.log("✅ jQuery ready → loading KaiAdmin...");
  await import("./kaiadmin.min.js").catch(err => console.error("⚠️ KaiAdmin load error:", err));
  await import("./demo.js").catch(() => {});
  await import("./setting-demo.js").catch(() => {});
  console.log("✅ KaiAdmin core initialized");
})();

// ─────────────────────────────
// 6️⃣ Chart.js + Plugins
// ─────────────────────────────
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
import { TreemapController, TreemapElement } from "chartjs-chart-treemap";

Chart.register(ChartDataLabels, TreemapController, TreemapElement);
window.Chart = Chart;
console.log("✅ Chart.js initialized with plugins");

// ─────────────────────────────
// 7️⃣ Sidebar & Navbar Responsive Behavior
// ─────────────────────────────
// ─────────────────────────────
// 7️⃣ Sidebar & Navbar Responsive Behavior (CSS-driven version)
// ─────────────────────────────
document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;
  const sidebar = document.querySelector(".sidebar");
  const toggleBtns = document.querySelectorAll(".toggle-sidebar, #sidebarCollapseBtn, .btn-toggle");
  const BREAKPOINT = 992;

  // ✅ Let CSS handle navbar width — only toggle sidebar states
  const adjustLayout = () => {
    if (window.innerWidth >= BREAKPOINT) {
      body.classList.remove("sidebar-open");
      if (sidebar) sidebar.style.transform = "translateX(0)";
    } else {
      if (sidebar) sidebar.style.transform = "translateX(-100%)";
    }
  };

  toggleBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      if (window.innerWidth < BREAKPOINT) {
        body.classList.toggle("sidebar-open");
      } else {
        body.classList.toggle("sidebar-collapsed");
      }

      console.log(
        "📂 Sidebar toggled:",
        body.classList.contains("sidebar-collapsed")
          ? "collapsed"
          : body.classList.contains("sidebar-open")
          ? "mobile open"
          : "expanded"
      );
    });
  });

  adjustLayout();
  window.addEventListener("resize", adjustLayout);

  // Sidebar active link
  $(".sidebar .nav-item a").on("click", function () {
    $(".sidebar .nav-item").removeClass("active");
    $(this).closest(".nav-item").addClass("active");
  });
});

// ─────────────────────────────
// 8️⃣ Role-Based Dashboard Loader
// ─────────────────────────────
const role = document.body.dataset.role || "";
console.log("👤 Current Role:", role);

(async () => {
  try {
    switch (role) {
      case "guest":
       // await import("./custom/admin.dashboard.js");
        console.log("📊 Admin dashboard loaded");
        break;
      case "industry":
        await import("./custom/industry.dashboard.js");
        console.log("🏭 Industry dashboard loaded");
        break;
      case "insurance":
        await import("./custom/insurance.dashboard.js");
        console.log("💼 Insurance dashboard loaded");
        break;
      default:
        console.log("ℹ️ No role-specific dashboard found");
        break;
    }
  } catch (err) {
    console.error("❌ Failed to load role dashboard:", err);
  }
})();

// ─────────────────────────────
// 9️⃣ Page-Specific CSS / JS Loader (Dynamic via data-page)
// ─────────────────────────────
// Map all page CSS files inside /resources/css/custom
const pageStyles = import.meta.glob('../css/custom/*.css', { as: 'url' });
document.addEventListener("DOMContentLoaded", async () => {
  const pageName = document.body.dataset.page || "";
  console.log("📄 Active page:", pageName);

  if (pageName === "insComplist") {
    const cssKey = "../css/custom/insurance-list.css";

    if (pageStyles[cssKey]) {
      const cssUrl = await pageStyles[cssKey](); // ✅ This gives you the correct Vite URL
      const link = document.createElement("link");
      link.rel = "stylesheet";
      link.href = cssUrl;
      document.head.appendChild(link);
      console.log("✅ CSS dynamically loaded:", cssUrl);
    } else {
      console.warn("⚠️ CSS file not found for key:", cssKey);
    }
  }
});

import $ from 'jquery';
window.$ = window.jQuery = $;
// loggedin.js — unified version for Vite
import * as bootstrap from 'bootstrap'; // ✅ Bootstrap 5 (includes Popper)
import Chart from 'chart.js/auto';

// ✅ Make Bootstrap globally available (for dropdowns, tooltips, etc.)
window.bootstrap = bootstrap;

console.log('🟢 i am logged in user');

/* ---------------------------
   DOM Ready / Sidebar + Navbar
   --------------------------- */
document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;
  const sidebar = document.querySelector(".sidebar");
  const navbar = document.getElementById("dashboardNavbar");
  const toggleBtn = document.querySelector(".toggle-sidebar");
  const BREAKPOINT = 992; // match your layout breakpoint

  // Safe guards
  if (!sidebar) console.warn('⚠️ .sidebar element not found');
  if (!navbar) console.warn('⚠️ #dashboardNavbar not found');
  if (!toggleBtn) console.warn('⚠️ .toggle-sidebar button not found');

  // Adjust layout depending on screen width
  function adjustLayout() {
    if (window.innerWidth > BREAKPOINT) {
      if (toggleBtn) toggleBtn.style.display = "none";
      body.classList.remove("sidebar-open");
      if (sidebar) sidebar.style.transform = "translateX(0)";
      if (navbar) {
        navbar.style.left = "250px";
        navbar.style.width = "calc(100% - 250px)";
      }
    } else {
      if (toggleBtn) toggleBtn.style.display = "inline-block";
      if (sidebar) sidebar.style.transform = "translateX(-100%)";
      if (navbar) {
        navbar.style.left = "0";
        navbar.style.width = "100%";
      }
    }
  }

  // ✅ Sidebar toggle
  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      const isOpen = body.classList.toggle("sidebar-open");
      if (sidebar) {
        sidebar.style.transform = isOpen ? "translateX(0)" : "translateX(-100%)";
      }
      if (navbar) {
        if (window.innerWidth <= BREAKPOINT) {
          navbar.style.left = "0";
          navbar.style.width = "100%";
        } else {
          navbar.style.left = "250px";
          navbar.style.width = "calc(100% - 250px)";
        }
      }
      console.log('📂 Sidebar toggled — open:', isOpen);
    });
  }

  // Initialize once and on resize
  adjustLayout();
  window.addEventListener("resize", adjustLayout);

  /* -------------
     🔽 DROPDOWN INITIALIZATION
     ------------- */
  try {
    const dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    dropdownElements.forEach((el) => new bootstrap.Dropdown(el));
    console.log('✅ Bootstrap dropdowns initialized');
  } catch (err) {
    console.error('❌ Bootstrap dropdown init failed:', err);
  }

  // ✅ Ensure dropdowns start closed (safety)
  document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
    menu.classList.remove('show');
    menu.style.display = '';
  });
});

/* ---------------------------------------
   Role-Based Dynamic Imports
--------------------------------------- */
const role = document.body.dataset.role || '';
console.log(`👤 Current Role: ${role}`);

(async () => {
  try {
    if (role === 'admin' || role === 'guest') {
      await import('./custom/admin.dashboard.js');
      console.log('📊 Admin dashboard script loaded');
    } else if (role === 'insurance') {
      await import('./custom/insurance.dashboard.js');
      console.log('💼 Insurance dashboard script loaded');
    } else if (role === 'industry') {
      await import('./custom/industry.dashboard.js');
      console.log('🏭 Industry dashboard script loaded');
    } else {
      console.log('ℹ️ No specific dashboard JS loaded');
    }
  } catch (err) {
    console.error('❌ Failed to load role-specific dashboard script:', err);
  }
})();

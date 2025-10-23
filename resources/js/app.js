<<<<<<< Updated upstream
import './bootstrap';
=======
/**
 * Laravel 10 + Vite | Main JS Entrypoint
 * ---------------------------------------
 * ✅ Loads jQuery first (global window.$)
 * ✅ Loads Bootstrap from npm
 * ✅ Dynamically loads KaiAdmin only after jQuery is ready
 * ✅ Registers Chart.js plugins
 * ✅ Imports global styles via app.css (Vite entry)
 * ✅ Supports page-specific imports (publicdashboard.js)
 */

// ─────────────────────────────
// 1️⃣ Load jQuery and expose globally
// ─────────────────────────────
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;
console.log('✅ jQuery attached globally version:', $.fn.jquery);

import 'jquery-validation'; // ✅ must come right after jQuery
// Optional debug check
console.log('✅ Validation loaded:', typeof $.fn.validate);

import CryptoJS from 'crypto-js';
console.log(typeof CryptoJS.AES);

// ─────────────────────────────
// SweetAlert2 (global)
// ─────────────────────────────
import Swal from 'sweetalert2';
window.Swal = Swal; // Expose globally for inline usage or scripts
console.log('✅ SweetAlert2 loaded globally');


// ─────────────────────────────
// ✅ Global CSRF setup for all AJAX calls
// ─────────────────────────────
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
  }
});

console.log('✅ Global CSRF token attached:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));



// ─────────────────────────────
// 2️⃣ Load Bootstrap (bundle includes Popper)
// ─────────────────────────────

// ─────────────────────────────
// Load Bootstrap & expose globally
// ─────────────────────────────
import * as bootstrap from 'bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// expose globally so inline/dom code & console can see it
window.bootstrap = bootstrap;

console.log('✅ bootstrap exposed globally:', !!window.bootstrap && !!window.bootstrap.Dropdown);

// ✅ Initialize dropdowns only once safely
document.addEventListener('DOMContentLoaded', () => {
    console.log("🔹 Initializing dropdowns...");
    const dropdownTriggers = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    dropdownTriggers.forEach(trigger => {
        const dd = bootstrap.Dropdown.getOrCreateInstance(trigger);

        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            dd.toggle();
        });
    });
});

// ✅ Optional: reinit only if KaiAdmin modifies DOM
window.addEventListener('kaiadmin:ready', () => {
    console.log("🔹 KaiAdmin ready — reinitializing dropdowns...");
    const dropdownTriggers = document.querySelectorAll('[data-bs-toggle=\"dropdown\"]');
    dropdownTriggers.forEach(trigger => bootstrap.Dropdown.getOrCreateInstance(trigger));
});



// ─────────────────────────────
// 3️⃣ Load KaiAdmin and optional scripts AFTER jQuery is ready
// ─────────────────────────────
(async () => {
    await new Promise(resolve => {
        const check = setInterval(() => {
            if (window.$ && typeof window.$ === 'function') {
                clearInterval(check);
                resolve();
            }
        }, 50);
    });

    console.log('✅ jQuery ready → loading KaiAdmin scripts');

    // KaiAdmin core files (require jQuery)
    await import('./kaiadmin.min.js').catch(err => console.warn('KaiAdmin load error', err));

    // Optional demo/config files (comment out in production)
    await import('./demo.js').catch(() => {});
    await import('./setting-demo.js').catch(() => {});
    

    console.log('✅ KaiAdmin + demo scripts loaded');
})();

// Conditionally import page JS (optional)
if (document.body.classList.contains('industry-register-page')) {
    import ('./custom/gstverification.js');
    import('./custom/industry.register.js');
  
}



// ─────────────────────────────
// 4️⃣ Chart.js + plugins
// ─────────────────────────────
>>>>>>> Stashed changes
import Chart from 'chart.js/auto';
//import ChartLabels from 'chartjs-plugin-labels';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import { TreemapController, TreemapElement } from 'chartjs-chart-treemap';
// Register datalabels
Chart.register(ChartDataLabels, TreemapController, TreemapElement);

<<<<<<< Updated upstream
// Expose globally
window.Chart = Chart;
=======
// ─────────────────────────────
// 5️⃣ jQuery DOM Ready block
// ─────────────────────────────
$(function () {
    console.log('✅ jQuery DOM ready — global scripts running');

    // Example: Footer contact form
    const $contactForm = $('#contactForm');
    if ($contactForm.length) {
        $contactForm.on('submit', function (e) {
            e.preventDefault();
            alert('Thank you! Your message has been submitted successfully.');
            this.reset();
        });
    }
});

// ─────────────────────────────
// 6️⃣ Conditional page-specific imports (auto-load by route)
// ─────────────────────────────
const currentPage = document.body.dataset.page || '';
console.log('current page:'+currentPage);

(async () => {
    await new Promise(resolve => {
        const wait = setInterval(() => {
            if (window.$ && typeof window.$ === 'function') {
                clearInterval(wait);
                resolve();
            }
        }, 50);
    });

    if (['publicdashboard', 'dashboard'].includes(currentPage)) {
        console.log(`🌍 Loading JS for page: ${currentPage}`);
        await import('./custom/publicdashboard.js')
            .then(() => console.log('✅ publicdashboard.js loaded successfully'))
            .catch(err => console.warn('⚠️ Failed to load publicdashboard.js:', err));
    }
})();
>>>>>>> Stashed changes

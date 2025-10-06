@include('home.header')
{{-- make sure bootstrap-icons is loaded (put this in your header if not already) --}}

<style>
/* ensure the toggle icon is visible and consistent */
.toggle-icon {
  font-size: 1.2rem;
  line-height: 1;
  margin-left: 8px;
  display: inline-block !important;
  vertical-align: middle;
  color: #fff; /* will match header text - change if needed */
}
/* make header look like before but be a button */
.card-header.btn-toggle {
  border: none;
  background: transparent;
  width: 100%;
  text-align: left;
  padding: .75rem 1rem;
}
.card-header.btn-toggle:focus { outline: none; box-shadow: none; }


</style>
<div class="container-fluid mt-4 mb-5">
    <div class="container">
        <h2 class="text-center mb-4" style="color:#084095; font-weight:bold;">
            Insurance Companies & Industry Summary Report
        </h2>
        <div class="row">
            <div class="accordion" id="erfAccordion">
            <!-- Insurance Companies Summary -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button fs-4 fw-bold bg-primary text-white" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#insuranceSummary"
                        aria-expanded="true"
                        aria-controls="insuranceSummary">
                    <i class="bi bi-building me-2"></i> Insurance Companies Summary
                </button>
                </h2>
                <div id="insuranceSummary" class="accordion-collapse collapse show"
                    aria-labelledby="headingOne" data-bs-parent="#erfAccordion">
                <div class="accordion-body">
                    <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                        <th>#</th>
                        <th>Insurance Company</th>
                        <th>Industries Covered</th>
                        <th>Total ERF Contribution (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($insuranceCompanies as $i => $row)
                        <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $row->name_of_insurance_company }}</td>
                        <td>{{ $row->industries }}</td>
                        <td>₹ {{ number_format($row->total_erf, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
            </div>

            <!-- Industry-wise ERF Contribution -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed fs-4 fw-bold bg-primary text-white" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#industrySummary"
                        aria-expanded="false"
                        aria-controls="industrySummary">
                    <i class="bi bi-gear me-2"></i> Industry-wise ERF Contribution
                </button>
                </h2>
                <div id="industrySummary" class="accordion-collapse collapse"
                    aria-labelledby="headingTwo" data-bs-parent="#erfAccordion">
                <div class="accordion-body">
                    <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                        <th>#</th>
                        <th>Industry</th>
                        <th>Insurance Company</th>
                        <th>Contribution (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($industries as $i => $row)
                        <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $row->name_of_insured_owner }}</td>
                        <td>{{ $row->name_of_insurance_company }}</td>
                        <td>₹ {{ number_format($row->contribution_to_erf_rs, 2) }}</td>
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
</div>
@include('home.footer')

<script>
document.addEventListener('DOMContentLoaded', function () {
  // quick check that bootstrap is loaded
  if (typeof bootstrap === 'undefined') {
    console.warn('Bootstrap JS not found. Collapse will not function.');
    return;
  }

  // get all our toggle buttons
  document.querySelectorAll('.card-header.btn-toggle').forEach(function(btn) {
    const targetSelector = btn.getAttribute('data-target');
    const collapseEl = document.querySelector(targetSelector);
    const icon = btn.querySelector('.toggle-icon');
    if (!collapseEl || !icon) return;

    // create bootstrap Collapse instance (do not auto toggle)
    const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });

    // initialize icon from element state
    const initOpen = collapseEl.classList.contains('show') || collapseEl.getAttribute('data-bs-show') === 'true';
    icon.classList.toggle('bi-dash-lg', initOpen);
    icon.classList.toggle('bi-plus-lg', !initOpen);
    btn.setAttribute('aria-expanded', initOpen ? 'true' : 'false');

    // click handler: explicitly toggle via API (works even if other JS interferes)
    btn.addEventListener('click', function (e) {
      // Accordion behavior: close other collapses when opening this one
      // Uncomment below to enable accordion (only one open at a time):
      /*
      if (!collapseEl.classList.contains('show')) {
        document.querySelectorAll('.collapse.show').forEach(function(openEl) {
          bootstrap.Collapse.getInstance(openEl)?.hide();
        });
      }
      */

      // toggle
      if (collapseEl.classList.contains('show')) {
        bsCollapse.hide();
      } else {
        bsCollapse.show();
      }
    });

    // update icon when bootstrap triggers shown/hidden events
    collapseEl.addEventListener('shown.bs.collapse', function () {
      icon.classList.remove('bi-plus-lg');
      icon.classList.add('bi-dash-lg');
      btn.setAttribute('aria-expanded', 'true');
    });
    collapseEl.addEventListener('hidden.bs.collapse', function () {
      icon.classList.remove('bi-dash-lg');
      icon.classList.add('bi-plus-lg');
      btn.setAttribute('aria-expanded', 'false');
    });
  });
});
</script>

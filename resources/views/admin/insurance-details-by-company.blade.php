<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')
<div class="container">
  <div class="main-panel">
  <div class="card mt-3">
     <div class="card-header">
        <h3>Welcome to  Dashboard</h3>
      </div>
      <div class="card-body">
        <div class="ms-md-auto py-2 py-md-0">
        <h4>Insurance Policies for <strong>{{ $company }}</strong></h4>
      


<div class="row mb-3 align-items-center">
    <!-- Left: Search Input -->
    <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="Search policy, owner, or business type">
    </div>

    <!-- Right: Export Button -->
    <div class="col-md-6 d-flex justify-content-end">
        <a href="{{ route('insurance.by.company.export', ['company' => $company, 'search' => $search]) }}"
           class="btn btn-success">
            Export to Excel
        </a>
    </div>
</div>
       
    <!-- Table container that will be updated -->
<div id="insuranceTable">
    @include('admin.partials.insurance-table', ['insuranceData' => $insuranceData])
</div>

   

</div>
        </div>
        <!----------------datashow--->
       <!-- Table to load details dynamically -->



      </div><!----card end--->
      

  </div>
</div>
</div>
<!----modal popup-->
<!-- Dynamic Modal -->
<div class="modal fade" id="policyModal" tabindex="-1" aria-labelledby="policyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="policyModalLabel">Policy Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex justify-content-center align-items-center" id="policyModalBody" style="min-height: 150px;">
    <div id="loadingSpinner" class="text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Fetching policy details...</p>
    </div>
    <div id="policyContent" class="w-100" style="display: none;"></div>
</div>
    </div>
  </div>
</div>


<!---end modalpopup-->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.view-policy-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const policyNumber = this.dataset.policy;

            const modalElement = document.getElementById('policyModal');
            const spinner = document.getElementById('loadingSpinner');
            const content = document.getElementById('policyContent');

            // Show modal and reset content
            spinner.style.display = 'block';
            content.style.display = 'none';
            content.innerHTML = '';

            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            // Fetch policy details
            fetch(`/erfp/insurance/ajax/${policyNumber}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(html => {
                    spinner.style.display = 'none';
                    content.style.display = 'block';
                    content.innerHTML = html;
                })
                .catch(error => {
                    spinner.style.display = 'none';
                    content.style.display = 'block';
                    content.innerHTML = `<div class="alert alert-danger">Failed to load policy data. Please try again later.</div>`;
                    console.error(error);
                });
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    let timer;

    searchInput.addEventListener('keyup', function () {
        clearTimeout(timer);

        timer = setTimeout(function () {
            const searchValue = searchInput.value;
            const company = @json($company);

            fetch(`/admin/insurance/${encodeURIComponent(company)}?search=${encodeURIComponent(searchValue)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('insuranceTable').innerHTML = html;
            });
        }, 300); // delay to reduce API calls
    });
});
</script>


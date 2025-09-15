<style>
  h5 {
    color: linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);
  }

  h3 {
    color: linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);
  }
  .card-body {
  overflow-x: hidden;
}

.table {
  width: 100%;
  table-layout: auto;
}

  
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')
<div class="container">
  <div class="main-panel ">
  

  
  <div class="card mt-3">
  <div class="card-body">

    <div class="d-flex justify-content-end align-items-center mb-3 px-3">
    <div class="row g-2 align-items-end mb-3">

<div class="col-auto">
  <label for="month_filter" class="form-label fw-semibold mb-0">Month</label>
  <select id="month_filter" class="form-select form-select-sm">
    <option value="">All</option>
    @for ($m = 1; $m <= 12; $m++)
      <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
    @endfor
  </select>
</div>

<div class="col-auto">
  <label for="year_filter" class="form-label fw-semibold mb-0">Year</label>
  <select id="year_filter" class="form-select form-select-sm">
    <option value="">All</option>
    @for ($y = now()->year; $y >= 2000; $y--)
      <option value="{{ $y }}">{{ $y }}</option>
    @endfor
  </select>
</div>

<div class="col-auto">
  <label for="from_date" class="form-label fw-semibold mb-0">From</label>
  <input type="date" id="from_date" class="form-control form-control-sm">
</div>

<div class="col-auto">
  <label for="to_date" class="form-label fw-semibold mb-0">To</label>
  <input type="date" id="to_date" class="form-control form-control-sm">
</div>

<div class="col-auto d-flex gap-2">
  <button id="filterBtn" class="btn btn-sm btn-primary mt-auto">
    <i class="bi bi-funnel"></i> Filter
  </button>
  <button id="resetBtn" class="btn btn-sm btn-secondary mt-auto">Reset</button>
</div>

</div>

      <a href="{{ route('dashboard.export', ['search' => request('search')]) }}" id="exportExcel" class="btn btn-success ms-auto px-4 py-2">
        <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
      </a>
    </div>

    <table id="policyTable" class="table table-bordered">
  <thead class="table-light">
    <tr>
      <th>#</th>
      <th>Batch Refrence</th>
      <th>Company Name</th>
      <th>Policy Number</th>
      
      <th>Date</th>
      <th>View Policy Document</th>
      <th>Action</th>
    </tr>
  </thead>
</table>
  </div>
</div>


    </div>
    </div>
    <!-----------------------------------------!-->
  <div class="modal fade" id="policyModal" tabindex="-1" aria-hidden="true"><!--------start modal--->
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Policy Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
      </div>
      <div class="modal-body" id="policyModalBody">
        <p>Loading...</p>
      </div>
      <div class="modal-footer">
        <a href="#" id="downloadPdfLink" class="btn btn-primary" target="_blank">
          <i class="bi bi-download"></i> Download PDF
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div><!--------end modal--->

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const policyModal = new bootstrap.Modal(document.getElementById('policyModal'));
const modalBody = document.getElementById('policyModalBody');
const pdfLink = document.getElementById('downloadPdfLink');

// Rebind view button after DataTables render
$('#policyTable').on('click', '.view-policy-btn', function () {
  const policyNumber = $(this).data('policy');

  modalBody.innerHTML = '<p>Loading...</p>';
  pdfLink.href = `/erfp/export-pdf/${policyNumber}`;

  $.get(`/erfp/policy-detailsIns/${policyNumber}`, function (data) {
  modalBody.innerHTML = data;
  policyModal.show();
  }).fail(function () {
    modalBody.innerHTML = '<p class="text-danger">Failed to load policy details.</p>';
  });
});
      });
  
</script>


<script>
$(document).ready(function () {
  let table = $('#policyTable').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
    url: '{{ route("ajax.company.policies") }}',
    data: function (d) {
      d.from_date = $('#from_date').val();
      d.to_date = $('#to_date').val();
      d.month = $('#month_filter').val();
      d.year = $('#year_filter').val();
    }
  },
  columns: [
  { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
  { data: 'batch_reference', name: 'batch_reference' },
  { data: 'insured_company_id', name: 'insured_company_id' },
  { data: 'policy_number', name: 'policy_number' },
  
  { data: 'created_at', name: 'created_at' },
  { data: 'documents', name: 'documents', orderable: false, searchable: false },
  { data: 'action', name: 'action', orderable: false, searchable: false }
]
});

// Trigger reload on filter
$('#filterBtn').on('click', function () {
  table.ajax.reload();
});

$('#resetBtn').on('click', function () {
  $('#from_date, #to_date, #month_filter, #year_filter').val('');
  table.ajax.reload();
});
});
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')
<div class="container">
  <div class="main-panel">
    <div class="card"><!----card start here-->
        <div class="card-body">
         <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"> <strong>{{ $company }}</strong></h5>
            <a href="{{route('insurance-summary') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Previous
            </a>
          </div>

                    <div class="row g-2 align-items-end mb-3">
                    <div class="col-auto">
                        <select id="year" class="form-select form-select-sm">
                        <option value="">Year</option>
                        @foreach($years as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <select id="month" class="form-select form-select-sm">
                        <option value="">Month</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endfor
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="date" id="from_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-auto">
                        <input type="date" id="to_date" class="form-control form-control-sm">
                    </div>
                    <div class="col-auto">
                        <button id="filterBtn" class="btn btn-sm btn-primary">Filter</button>
                        <button id="resetBtn" class="btn btn-sm btn-secondary">Reset</button>
                    </div>
                    <div class="col-auto ms-auto">
                        <a href="#" id="excelExport" class="btn btn-success btn-sm">Export Excel</a>
                    </div>
                    </div>

                        <table class="table table-bordered" id="policyTable">
                        <thead>
                            <tr>
                            <th>Sr.N</th>
                            <th>Policy Number</th>
                            <th>Insured Owner Name</th>
                            <th> Policy Provider</th>
                            
                            <th>Date</th>
                            <!-- <th>Document</th> -->
                            <th>Action</th>
                            </tr>
                        </thead>
                        </table>
            </div><!--card--body end here -->

        </div><!----card end here --->
    </div>
  </div>
  </div>
<!-----modal---->
<div class="modal fade" id="policyModal" tabindex="-1" aria-hidden="true">
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
          <i class="bi bi-download"></i> Download Policy Details
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>


<!----end div--->
  <script>
$(function () {
  const company = "{{ $company }}";

  let table = $('#policyTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: `/admin/insurance-company/${company}/data`,
      data: function (d) {
        d.year = $('#year').val();
        d.month = $('#month').val();
        d.from_date = $('#from_date').val();
        d.to_date = $('#to_date').val();
      }
    },
    columns: [
       { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'policy_number', name: 'policy_number' },
      { data: 'name_of_insured_owner', name: 'name_of_insured_owner' ,width: '250px'},
      
      { data: 'company_name', name: 'company_name' },
      { data: 'created_at', name: 'created_at',width: '100px' },
     // { data: 'documents', name: 'documents', orderable: false, searchable: false },
      { data: 'action', name: 'action', orderable: false, searchable: false },
    ]
  });

  $('#filterBtn').click(() => table.ajax.reload());
  $('#resetBtn').click(() => {
    $('#year, #month, #from_date, #to_date').val('');
    table.ajax.reload();
  });

  $('#excelExport').click(e => {
    e.preventDefault();
    const query = new URLSearchParams({
      year: $('#year').val(),
      month: $('#month').val(),
      from_date: $('#from_date').val(),
      to_date: $('#to_date').val()
    }).toString();

    window.location.href = `/admin/insurance-company/${company}/export/excel?${query}`;
  });
  const policyModal = new bootstrap.Modal(document.getElementById('policyModal'));

$('#policyTable').on('click', '.view-policy-btn', function () {
  const policyNumber = $(this).data('policy');
  const doubleEncodedPolicyNumber = encodeURIComponent(encodeURIComponent(policyNumber));
   

  $('#policyModalBody').html('<p>Loading...</p>');
  $('#downloadPdfLink').attr('href', `/policy-details/${policyNumber}/pdf`);

  $.get(`/policy-details/${doubleEncodedPolicyNumber}`, function (data) {
    $('#policyModalBody').html(data);
    policyModal.show();
  }).fail(() => {
    $('#policyModalBody').html('<p class="text-danger">Error loading policy details.</p>');
  });
});



});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
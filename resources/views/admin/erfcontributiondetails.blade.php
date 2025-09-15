<style>
    .custom-erf-table th {
    background-color: #e6f0ff;
    font-weight: 600;
    color: #084095;
}

.custom-erf-table td {
    background-color: #fcfcfc;
    color: #333;
}

.custom-erf-table tbody tr:hover {
    background-color: #f2f7ff;
}

</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')
<input type="hidden" id="encryptedUserId" value="{{ $encryptedUserId }}">
  <div class="main-panel">

  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary">ERF Contribution  Fund Summary by Insurance Company</h5>
    
         <a href="{{route('erfcontsummary') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Previous
            </a>
    
      </div>
    
    <div class="card-body p-3">
     <div class="row mb-3">
    <div class="col-md-2">
        <input type="number" id="filterYear" class="form-control" placeholder="Year">
    </div>
    <div class="col-md-2">
        <input type="date" id="startDate" class="form-control" placeholder="Start Date">
    </div>
    <div class="col-md-2">
        <input type="date" id="endDate" class="form-control" placeholder="End Date">
    </div>
   <div class="col-md-3">
    <select id="filterUTR" class="form-select">
        <option value="">-- Select UTR --</option>
    </select>
</div>
    <div class="col-md-3">
        <button id="filterBtn" class="btn btn-primary">Filter</button>
        <button id="resetBtn" class="btn btn-secondary">Reset</button>
        
    </div>
</div>
<div class="row mb-3">
  <div class="col-md-6">
         <button id="exportExcel" class="btn btn-success">Export to Excel</button>
        <button id="exportCustomPdfBtn" class="btn btn-danger">Export to PDF</button>
        
    </div>
 
</div>

<table class="table table-bordered" id="erfTable">
        <thead>
            <tr>
              <th> S.No</th>
                <th>Policy Number</th>
                <th>Owner Name</th>
                <th>Insurance company</th>
                <th>UTR Number</th>
                <th>Contribution (₹)</th>
                <th>Date of Payment</th>
            </tr>
        </thead>
    </table>
    </div>
</div>
  </div>
  <script>
    const encryptedUserId = @json($encryptedUserId);
</script>
<script>
$(document).ready(function () {
    const encryptedUserId = $('#encryptedUserId').val();

    $.ajax({
        url: '{{ route("erf.get-utrs") }}',
        data: { encrypted_user_id: encryptedUserId },
        success: function (data) {
            if (Array.isArray(data)) {
                $('#filterUTR').append(
                    data.map(utr => `<option value="${utr}">${utr}</option>`)
                );
            }
        }
    });

    // DataTables initialization
    let table = $('#erfTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("erf.data") }}',
            data: function (d) {
                d.year = $('#filterYear').val();
                d.start_date = $('#startDate').val();
                d.end_date = $('#endDate').val();
                d.erf_deposit_utr_no = $('#filterUTR').val();
                d.encrypted_user_id = encryptedUserId;
            }
        },
        columns: [
          {
        data: null,
        name: 'serial',
        render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        },
        orderable: false,
        searchable: false
    },
            { data: 'policy_number' },
            { data: 'name_of_insured_owner' },
            {data: 'insurance_company'},
            { data: 'erf_deposit_utr_no' },
           
            { data: 'contribution_to_erf_rs' },
            { data: 'date_of_erf_payment' }
        ]
    });

    $('#filterBtn').click(() => table.draw());
    $('#resetBtn').click(() => {
        $('#filterYear').val('');
        $('#startDate').val('');
        $('#endDate').val('');
        $('#filterUTR').val('');
        table.draw();
    });


    $('#filterBtn').click(() => table.draw());
    $('#resetBtn').click(() => {
        $('#filterYear, #startDate, #endDate, #filterUTR').val('');
        table.draw();
    });

   function buildExportUrl(type) {
    const encryptedUserId = $('#encryptedUserId').val();
    
    const params = {
        encrypted_user_id: encryptedUserId,
        year: $('#filterYear').val(),
        start_date: $('#startDate').val(),
        end_date: $('#endDate').val(),
        erf_deposit_utr_no: $('#filterUTR').val()
    };

    return `{{ url('/erf-data/export') }}/${type}?` + $.param(params);
}

$('#exportExcel').click(() => window.location.href = buildExportUrl('excel'));
$('#exportCustomPdfBtn').click(function () {
    const params = {
        encrypted_user_id: $('#encryptedUserId').val(),
        year: $('#filterYear').val(),
        start_date: $('#startDate').val(),
        end_date: $('#endDate').val(),
        erf_deposit_utr_no: $('#filterUTR').val()
    };

    const url = '{{ route("erf.export.custom-pdf") }}?' + $.param(params);
    window.open(url, '_blank');
});

});
</script>
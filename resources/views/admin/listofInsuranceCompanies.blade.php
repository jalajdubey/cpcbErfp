<style>
 .custom-table {
    font-size: 14px;
    border-radius: 6px;
}

.custom-table thead th {
    background-color: #f8f9fc;
    color: #333;
    font-weight: 600;
    white-space: nowrap;
}

.custom-table tbody tr:hover {
    background-color: #f4f6fa;
}

.custom-table td a {
    color: #0d6efd;
    text-decoration: none;
}

.custom-table td a:hover {
    text-decoration: underline;
}

</style>

<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')

  <div class="main-panel">
  <div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Insurance Company List</h5>
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>
    <div class="card-body p-0">
        <div class="table-responsive"> <!-- Enables horizontal scroll only -->
            <table class="table table-bordered table-striped custom-table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="min-width: 50px;">#</th>
                        <th style="min-width: 250px;">Name of General Insurance Company</th>
                        <th style="min-width: 200px;">Name of CEO</th>
                        <th style="min-width: 200px;">Name of Actuary</th>
                        <th style="min-width: 150px;">Contact No</th>
                        <th style="min-width: 250px;">Web Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($getDetails as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->name_of_general_insurance_company }}</td>
                            <td>{{ $row->name_of_ceo }}</td>
                            <td>{{ $row->name_of_actuary }}</td>
                            <td>{{ $row->contact_no }}</td>
                            <td>
                                <a href="{{ $row->web_address }}" target="_blank">{{ $row->web_address }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



  </div>
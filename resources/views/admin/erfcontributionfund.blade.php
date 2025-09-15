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

  <div class="main-panel">

  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary">ERF Contribution Summary by Insurance Company</h5>
    </div>

    <div class="card-body p-3">
        <table class="table table-bordered table-striped align-middle custom-erf-table">
            <thead class="table-primary">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Insurance Company</th>
                    <th>Total Number of Policy</th>
                    <th scope="col">Total Contribution to ERF (₹)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row->apiKey->name_of_general_insurance_company ?? 'N/A' }}</td>
                          <td>{{ $row->total_policies }}</td>
                        <!-- <td>{{ $row->user_id }}</td> -->
                      
                           @php
                             
                            $encryptedId = Crypt::encryptString($row->user_id);
                            @endphp
                         
                          <td>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('view-form-{{ $row->user_id }}').submit();">
                                ₹{{ number_format($row->total_contribution, 2) }}
                            </a>

                            <form id="view-form-{{ $row->user_id }}" action="{{ route('fundcontribution.details.post', ['encrypted' => $encryptedId]) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="encrypted_user_id" value="{{ $encryptedId }}">
                            </form>
                            </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
             <tfoot>
        <tr>
            <th colspan="2" style="text-align: right">Overall Total</th>
            <th>{{ $globalTotals->overall_policies }}</th>
            <th>₹ {{ number_format($globalTotals->overall_contribution, 2) }}</th>
        </tr>
    </tfoot>
        </table>
    </div>
</div>
  </div>

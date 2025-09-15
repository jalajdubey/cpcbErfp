<style>
    .card .card-body h3 {
    font-size: 2rem;
    font-weight: 700;
}
.card .card-body .fs-6 {
    font-size: 1rem;
}
    .custom-summary-card {
    background-color: #f8fafd;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.custom-summary-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
}

.policy-link {
    color: #084095;
    text-decoration: none;
}

.policy-link:hover {
    text-decoration: underline;
    color: #0a58ca;
}

.card-header h3 {
    font-size: 1.4rem;
    font-weight: 600;
}

</style>


<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')

  <div class="main-panel">
  <div class="card mt-3 border-0 shadow-sm">
  <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Insurance Summary Dashboard</h5>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Previous
            </a>
          </div>

    <div class="card-body">
        <div class="container py-3">
            <div class="row g-4">
                @php
                    $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-secondary'];
                    $i = 0;
                @endphp

                @forelse($companies as $company)
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="card text-white {{ $colors[$i++ % count($colors)] }} bg-gradient border-0 shadow-sm h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold fs-6">{{ $company->company_name }}</div>
                                    <small class="text-white-50">Total Policies Issued</small>
                                </div>
                                <h3 class="mb-0">
                                    @php
                                    $encodedCompany = urlencode(base64_encode(Crypt::encryptString($company->company_name)));
                                    @endphp
                                  
                                    <a href="{{ route('admin.insurance-company', ['company' => $encodedCompany]) }}" class="text-white text-decoration-none">
                                        {{ $company->total_policies }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">No insurance data found.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

</div>

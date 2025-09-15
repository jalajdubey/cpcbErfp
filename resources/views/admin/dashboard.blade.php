<style>
 <style>
    /* Base styles */
    body {
      background-color: #f8f9fc;
      font-family: 'Segoe UI', sans-serif;
    }

    /* Title */
    .dashboard-title {
      text-align: center;
      color: #084095;
      font-size: 1.75rem;
      font-weight: 700;
      margin-bottom: 2.5rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Card layout */
    .dashboard-card {
      background: linear-gradient(to bottom right, #ffffff, #f5f9ff);
      border: 1px solid #dee2e6;
      border-radius: 16px;
      padding: 25px 20px;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .dashboard-card:hover {
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      transform: translateY(-5px);
    }

    /* Icon circle */
    .icon-circle {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      font-size: 20px;
      margin-bottom: 12px;
      color: #fff;
    }

    /* Color options */
    .bg-icon-blue    { background-color: #0d6efd; }
    .bg-icon-green   { background-color: #198754; }
    .bg-icon-orange  { background-color: #fd7e14; }
    .bg-icon-red     { background-color: #dc3545; }
    .bg-icon-teal    { background-color: #20c997; }
    .bg-icon-yellow  { background-color: #ffc107; color: #000; }
    .bg-icon-gray    { background-color: #6c757d; }
    .bg-icon-indigo  { background-color: #6610f2; }

    /* Card text */
    .dashboard-label {
      font-size: 16px;
      font-weight: 600;
      color: #212529;
      margin-bottom: 6px;
    }

    .dashboard-count {
      font-size: 14px;
      color: #6c757d;
    }

    /* View button */
    .btn-view {
      font-size: 13px;
      padding: 5px 18px;
      background-color: #eaf1fb;
      color: #084095;
      border-radius: 25px;
      border: 1px solid #cfe2ff;
      transition: all 0.2s ease;
      font-weight: 500;
    }

    .btn-view:hover {
      background-color: #d0e4ff;
      color: #063073;
      border-color: #a4c7f7;
    }

    /* Responsive tweaks */
    @media (max-width: 576px) {
      .dashboard-card {
        padding: 20px 15px;
      }

      .btn-view {
        width: 100%;
        padding: 6px;
      }
    }
  </style>
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')

  <div class="main-panel">
  
    <div class="card mt-3">
    
    <h2 class="dashboard-title">Environmental Relief Fund (ERF) - CPCB Dashboard</h2>
  <div class="row g-4">

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-blue"><i class="bi bi-speedometer2"></i></div>
          <div class="dashboard-label">Total Insurance Company Registered</div>
          <div class="dashboard-count" style="color:#0d6efd;font-weight:bold">{{$uniqueUserCount}}</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> 
        <a href="{{ route('insComplist') }}">View</a>
        </button>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-green"><i class="bi bi-bar-chart-line"></i></div>
          <div class="dashboard-label">Total Number of Policy Issued By Insurance Company </div>
          <div class="dashboard-count" style="color:orange;font-weight:bold">Total: {{ $totalPolicylist }}</div>
        </div>
        <button class="btn btn-view mt-2">
          
          <i class="bi bi-eye me-1"></i> 
          <a href="{{ route('insurance-summary') }}"> 
          View</a></button>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-orange"><i class="bi bi-ui-checks-grid"></i></div>
          <div class="dashboard-label">Total Contribution of ERF fund in Rs</div>
          <div class="dashboard-count" style="color:#198754;font-weight:bold">Total:Rs. {{format_inr($totalContribution, 2)}} </div>
        </div> 
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i>
         <a href="{{ route('erfcontsummary') }}"> 
        View</a>
      </button>
      </div>
    </div>

    <!-- <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-red"><i class="bi bi-table"></i></div>
          <div class="dashboard-label">Beneficiary List</div>
          <div class="dashboard-count">Total: 120</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div> -->

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-teal"><i class="bi bi-people"></i></div>
          <div class="dashboard-label">Registered Industry</div>
          <div class="dashboard-count">Total: 0</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div>

    <!-- <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-yellow"><i class="bi bi-calendar-event"></i></div>
          <div class="dashboard-label">Event Calendar</div>
          <div class="dashboard-count">Upcoming: 5</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-gray"><i class="bi bi-pie-chart-fill"></i></div>
          <div class="dashboard-label">Fund Allocation</div>
          <div class="dashboard-count">₹12.5 Cr</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="dashboard-card">
        <div>
          <div class="icon-circle bg-icon-indigo"><i class="bi bi-file-earmark-text"></i></div>
          <div class="dashboard-label">Policy Documents</div>
          <div class="dashboard-count">Total: 18</div>
        </div>
        <button class="btn btn-view mt-2"><i class="bi bi-eye me-1"></i> View</button>
      </div>
    </div> -->

  </div>
 </div>
</div>












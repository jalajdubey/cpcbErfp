<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  .dashboard-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding:5px !important;
    min-height: 50px;
  }

  .dashboard-card:hover {
    transform: translateY(-5px) scale(1.02);
  }

  .dashboard-icon {
    transition: transform 0.3s ease;
  }

  .dashboard-card:hover .dashboard-icon {
    transform: scale(1.15) rotate(4deg);
  }

  .bg-primary:hover {
    box-shadow: 0 0 1rem rgba(13, 110, 253, 0.4);
  }

  .bg-success:hover {
    box-shadow: 0 0 1rem rgba(25, 135, 84, 0.4);
  }

  .bg-warning:hover {
    box-shadow: 0 0 1rem rgba(255, 193, 7, 0.4);
  }

  .bg-danger:hover {
    box-shadow: 0 0 1rem rgba(220, 53, 69, 0.4);
  }

  .card-body {
    padding: 5px !important;
  }

  .card-footer {
    padding: 0.5rem;
  }

  .dashboard-title {
    font-size: 0.95rem;
    margin-top: 0.5rem;
  }

  .dashboard-count {
    font-size: 1.4rem;
    margin-bottom: 0;
  }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')

  <div class="main-panel">
  
<div class="card">
      <div class="container mt-3">
  <div class="row g-3">

    <!-- Card 1 -->
    <div class="col-sm-6 col-lg-3">
      <div class="card dashboard-card text-white bg-primary rounded-3 shadow-sm ">
        <div class="card-body text-center">
          <i class="bi bi-people-fill fs-3 dashboard-icon"></i>
          <div class="dashboard-title fw-semibold">Profile Summary</div>
          <p class="dashboard-count" style="visibility: hidden;"><span class="count" data-count="1245">0</span></p>
        </div>
        <div class="card-footer text-center bg-transparent border-0">
          <a href="{{ route('profilelist') }}" class="btn btn-light btn-sm rounded-pill" data-bs-toggle="tooltip" title="View active policies">
            View Details
          </a>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-sm-6 col-lg-3">
      <div class="card dashboard-card text-white bg-success rounded-3 shadow-sm ">
        <div class="card-body text-center">
          <i class="bi bi-shield-check fs-3 dashboard-icon"></i>
          <div class="dashboard-title fw-semibold">Active Policies</div>
          <p class="dashboard-count" style="visibility: hidden;" ><span class="count" data-count="534">0</span></p>
        </div>
        <div class="card-footer text-center bg-transparent border-0">
          <button class="btn btn-light btn-sm rounded-pill" data-bs-toggle="tooltip" title="View active policies">View Details</button>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-sm-6 col-lg-3">
      <div class="card dashboard-card text-dark bg-warning rounded-3 shadow-sm ">
        <div class="card-body text-center">
          <i class="bi bi-clock-history fs-3 dashboard-icon"></i>
          <div class="dashboard-title fw-semibold">Pending Requests</div>
          <p class="dashboard-count" style="visibility: hidden;"><span class="count" data-count="78">0</span></p>
        </div>
        <div class="card-footer text-center bg-transparent border-0">
          <button class="btn btn-dark btn-sm rounded-pill" data-bs-toggle="tooltip" title="View pending list">View Details</button>
        </div>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="col-sm-6 col-lg-3">
      <div class="card dashboard-card text-white bg-danger rounded-3 shadow-sm ">
        <div class="card-body text-center">
          <i class="bi bi-exclamation-triangle-fill fs-3 dashboard-icon"></i>
          <div class="dashboard-title fw-semibold">Failed Logins</div>
          <p class="dashboard-count" style="visibility: hidden;"><span class="count" data-count="14">0</span></p>
        </div>
        <div class="card-footer text-center bg-transparent border-0">
          <button class="btn btn-light btn-sm rounded-pill" data-bs-toggle="tooltip" title="View failed logins">View Details</button>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
<!------modalpoup---->
<x-industry-registration-details ::users="$users"/>
<!-- Modal -->



  <script>
  // Count-up animation
  document.querySelectorAll('.count').forEach((el) => {
    let target = +el.getAttribute('data-count');
    let count = 0;
    let step = Math.ceil(target / 50);

    let interval = setInterval(() => {
      count += step;
      if (count >= target) {
        count = target;
        clearInterval(interval);
      }
      el.textContent = count;
    }, 20);
  });

  // Bootstrap tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
</script>









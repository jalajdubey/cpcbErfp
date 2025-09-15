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

        <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Insured Company Id</th>
                <th>Name Of Insured Owner	</th>
                <th>Business Type</th>
                <th>User Id</th>
                <th>Created At</th>
                <!-- Add more columns if needed -->
            </tr>
        </thead>
        <tbody>
            @forelse($insuarnceData as $industry)
                <tr>
                    <td>{{ $industry->id }}</td>
                    <td>{{ $industry->insured_company_id	 ?? 'N/A' }}</td>
                    <td>{{ $industry->name_of_insured_owner	 ?? 'N/A' }}</td>
                    <td>{{ $industry->business_type ?? 'N/A' }}</td>
                    <td>{{ $industry->user_id }}</td>
                    <td>{{ $industry->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No insurance data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        </div>
        
      </div>
      

  </div>
</div>
</div>
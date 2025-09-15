<style>
  h5 {
    color: linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);
  }

  h3 {
    color: linear-gradient(269.87deg, #084095 2.99%, #108e16 96.59%);
  }
  
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('layouts.header')

@include('layouts.sidebar')
@include('layouts.top-navbar')
<div class="container">
  <div class="main-panel">
  

  
    <div class="card mt-3">
    
      <div class="card-header">
        <h3>Welcome to  Industries</h3>
      </div>
      <div class="card-body">
        <div class="ms-md-auto py-2 py-md-0">

          <a href="#" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#industryregisterModal">Verify
            KYC Details</a>
        </div>
      </div>
    </div>
   
  </div>
 
</div>
<!------modalpoup---->
<x-industry-registration-details ::users="$users"/>
<!-- Modal -->











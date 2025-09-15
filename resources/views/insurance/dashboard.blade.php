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
        <h3>Welcome to  {{$companyName}}</h3>
      </div>
      <div class="card-body">
      <div class="row">
						<div class="col-sm-6 col-md-4">
							<div class="card card-stats card-round">
								<div class="card-body ">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class='fas fa-clone'></i>
											</div>
										</div>
										<div class="col col-stats ms-3 ms-sm-0">
											<div class="numbers">
												<p class="card-category"><strong>Total Number Of Policy</strong></p>
                                               <h4 class="card-title">
													@php
													

													$encryptedCompany = urlencode(base64_encode(Crypt::encryptString($companyName)));
												@endphp
												<a href="{{ route('company.policies', ['company' => $encryptedCompany]) }}" style="text-decoration: none; color: inherit;">
                                             {{ $totalPolicies }}
                                                                    </a>
                                                                    </h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-sm-6 col-md-4">
							<div class="card card-stats card-round">
								<div class="card-body ">
									<div class="row align-items-center">
										<div class="col-icon">
											<div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class='fas fa-clone'></i>
											</div>
										</div>
										<div class="col col-stats ms-3 ms-sm-0">
											<div class="numbers">
												<p class="card-category"><strong>Total Amount for ERFP</strong></p>
                                                <h4 class="card-title">
                                                <a href="{{ route('company.policies', ['company' => $companyName]) }}" style="text-decoration: none; color: inherit;">
                                                                        {{  $totalAmount   }}
                                                                    </a>
                                                                    </h4>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div><!---end row-->
      </div><!---end cardbody--->
    </div><!---end card-->
        <!----colo[s]--->





<html>
<head>
<style>
  .card-category{
    color: linear-gradient(45deg, #084095, #108e16);
  }
.leader .box {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 16px;
  margin: 15px auto; /* spacing between boxes */
  max-width: 260px; /* small box size */
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
  text-align: center;
}

.leader .box:hover {
  transform: translateY(-5px);
}

.leader .box img {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border-radius: 50%;
  margin: 0 auto 12px;
  border: 3px solid #063377;
}

.leader .box h4 {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 4px;
  color: #063377;
}

.leader .box h5 {
  font-size: 0.9rem;
  font-weight: 400;
  color: #555;
}

/* Tooltip styling */
.tooltip-custom {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.tooltip-custom .tooltip-text {
  visibility: hidden;
  background-color: #063377;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 6px 10px;
  position: absolute;
  z-index: 10;
  bottom: 120%;
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  transition: opacity 0.3s ease;
  font-size: 0.75rem;
  white-space: nowrap;
}

.tooltip-custom:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}


/* Responsive */
@media (max-width: 767.98px) {
  .leader .box img {
    width: 120px;
    height: 120px;
  }

  .leader .box {
    margin-bottom: 30px;
  }
}


</style>


</head>

@include('home.header')

    <!-----end navigation---->
    <div id="environmentCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#environmentCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#environmentCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#environmentCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('images/1.webp') }}" class="d-block w-100" alt="Environmental Relief Introduction">
      <div class="carousel-caption d-none d-md-block">
        <h5>Welcome to the Environmental Relief Fund</h5>
        <p>Help us make a difference in protecting our planet.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('images/scheme_2024.png') }}" class="d-block w-100" alt="Current Projects">
      <div class="carousel-caption d-none d-md-block">
        <h5>Current Projects</h5>
        <p>Learn about our ongoing efforts to combat environmental challenges.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('images/slide2.jpg') }}" class="d-block w-100" alt="Get Involved">
      <div class="carousel-caption d-none d-md-block">
        <h5>Get Involved</h5>
        <p>Discover how you can contribute to our cause.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#environmentCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#environmentCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-----hero section start here--->

<!----mid section start here ----->
<div class="miupdate updatebg">
   <div class="container-fluid my-3">
     <div class="row ">
    <div class="col-md-12 col-sm-12 col-lg-12">
         <div class="update-section container mt-2">
            <h3>Latest Update:</h3>
         </div>
    </div>
</div>

</div>
</div><!----end update section--->
<!----start ev section--->
 <div class="evsection">
<div class="container my-3">
  <div class="leader">
  <div class="container mt-4 mb-4">
    <div class="row text-center">
      <div class="col-md-6 col-12">
        <div class="box row">
         <p class="card-category"><strong>Total Number of Policy Recived</strong></p>
                          <h4 class="card-title">{{  $totalPolicylist }}</h4>
        </div>
      </div>
      
      <div class="col-md-6 col-12">
        <div class="box row">
         <p class="card-category"><strong>Total Insurance Company</strong></p>
                          <h4 class="card-title">{{$uniqueUserCount}}</h4>
        </div>
      </div>
    </div>
  </div>
</div>  
</div>
</div> 
      
<!-----leader section--->
<div class="leader">
  <div class="container mt-4 mb-4">
    <div class="row text-center">
      <div class="col-md-4 col-12">
        <div class="box row">
          <img src="{{ asset('images/narendra-modi-bjp.jpg') }}" alt="Sh. Narendra Modi">
          <h4>Sh. Narendra Modi</h4>
          <h5 class="tooltip-custom">
            (Hon'ble Prime Minister)
            <span class="tooltip-text">Prime Minister of India</span>
          </h5>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="box row">
          <img src="{{ asset('images/Bhupender-Yadav.jpg') }}" alt="Sh. Bhupender Yadav">
          <h4>Sh. Bhupender Yadav</h4>
          <h5 class="tooltip-custom">
            (Hon'ble Minister of EF&CC)
            <span class="tooltip-text">Environment, Forest and Climate Change</span>
          </h5>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="box row">
          <img src="{{ asset('images/Kirtivardhansingh.jpg') }}" alt="Sh. Kirtivardhan Singh">
          <h4>Sh. Kirtivardhan Singh</h4>
          <h5 class="tooltip-custom">
            (Hon'ble Minister of State of EF&CC)
            <span class="tooltip-text">Minister of State, EF&CC</span>
          </h5>
        </div>
      </div>
    </div>
  </div>
</div>
<!-----footer start here--->

@include('home.footer')

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
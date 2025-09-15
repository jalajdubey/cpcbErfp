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
.landing-banner-bg {
    background-image:url('{{ asset('images/Background.926d08221b4c6978.png') }}'); /* 🔁 Replace with your desired background image path */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 30px 0;
    height:70%;
  }

  .carousel img {
    border-radius: 10px;
  }

  .alert {
    background-color: rgba(255, 255, 255, 0.85); /* Make alerts semi-transparent for better readability */
    backdrop-filter: blur(5px);
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
.custom-underline {
  position: relative;
  display: inline-block;
}

.custom-underline::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -5px;
  width: 100%;
  height: 3px;
  background-color: #198754; /* Bootstrap green or any color */
  border-radius: 2px;
}

.announcement-container {
  max-height: 320px; /* Adjust as needed */
  overflow: hidden;
  position: relative;
}

.announcements {
  display: inline-block;
  animation: scroll-up 25s linear infinite;
  padding-left: 0;
  margin-bottom: 0;
}

@keyframes scroll-up {
  0% {
    transform: translateY(0%);
  }
  100% {
    transform: translateY(-100%);
  }
}

/* Optional: remove bottom borders between list items */
.announcements .list-group-item {
  border: none;
  padding: 0.5rem 1rem;
}
.announcement-container:hover .announcements {
  animation-play-state: paused;
}

</style>

</head>

@include('home.header')

    
<div class="container-fluid landing-banner-bg">
  <div class="container py-1 ">
  <div class="row align-items-start">
    <!-- Left: Bootstrap Carousel Slider -->
    <div class="col-lg-12">
      <div id="landingCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('images/scheme_2024.png') }}" class="d-block w-80" alt="Slide 1">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/1.webp') }}" class="d-block w-80" alt="Slide 2">
          </div>
         
          <!-- Add more slides as needed -->
          <div class="carousel-item">
            <img  src="{{ asset('images/scheme_2024.png') }}" class="d-block w-80" alt="Slide 4">
          </div>
          <!-- ... Continue up to ewaste18-min.jpeg -->
        </div>
        <!-- Navigation arrows -->
        <button class="carousel-control-prev" type="button" data-bs-target="#landingCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#landingCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>

    <!-- Right: Alerts and Notifications -->
    <!-- <div class="col-lg-4 mt-4 mt-lg-0">
      <div class="alert alert-danger border border-secondary rounded p-3" role="alert" style="font-size: 14px;">
        <strong>Important:</strong> CPCB is conducting meetings via VC for Producer and Recycler registration and EPR credit discussions.
        <br><br>
        Timings: <b>4PM to 5PM, Monday to Saturday</b>
        <br>
        Join Link:
        <a href="https://meet.google.com/rcp-trpu-ggx?pli=1" target="_blank" class="text-decoration-underline text-primary">
          https://meet.google.com/rcp-trpu-ggx?pli=1
        </a>
      </div>

      <div class="alert alert-warning border border-secondary rounded p-3 mt-3" role="alert" style="font-size: 16px;">
        <strong>Kind Attention to Recycler:</strong><br><br>
        Submit your sales data and generate denominated EPR certificate for FY 2024-25 before <b>30.06.2025</b> or filing of Annual Return (whichever is earlier). Valid for 2 years as per E-Waste (Management) Rules, 2022.
      </div>
    </div> -->
  </div>
</div>
</div>




<!-----hero section start here--->

<!----mid section start here ----->
<div class="miupdate updatebg mt-1">
   <div class="container-fluid">
     <div class="row ">
    <div class="col-md-12 col-sm-12 col-lg-12">
         <div class="update-section container mt-2">
            <h3>Latest Update:</h3>
         </div>
    </div>
</div>

</div>
</div>

<!----end update section--->
<!----start ev section--->
 
    


<div class="container-fluid" style="background:#fff;">

  <div class="container py-4">
  <div class="row">
    <!-- Left Section -->
  <div class="col-lg-8 mb-4">
  <h3 class="h3 mb-3 titleh3 custom-underline">
    ERF Portal for ENVIRONMENT RELIEF FUND SCHEME MANAGEMENT SYSTEM
  </h3>
  <p>
    The Central Pollution Control Board (CPCB) is being entrusted with the
    management of the Environment Relief Fund (ERF) starting January 1, 2025,
    as part of an amendment to the ERF scheme according to the Ministry of Environment,
    Forest and Climate Change. This shift, initiated by the Central Government, aims to address
    issues related to fund utilization and compensation delays in cases of industrial accidents
    involving hazardous substances. The CPCB will act as the Fund Manager for five years, starting
    January 1, 2025.
  </p>

  <ul class="erf-list">
    <li>Ensure timely disbursal of compensation to affected individuals and communities.</li>
    <li>Maintain transparent records of ERF collections and disbursements.</li>
    <li>Coordinate with insurance companies and relevant agencies for claim processing.</li>
    <li>Implement monitoring mechanisms to track industrial compliance.</li>
    <li>Promote awareness about the ERF scheme among stakeholders and industries.</li>
  </ul>
</div>


    <!-- Right Section -->
    <div class="col-lg-4">
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white" style="background-image: linear-gradient(45deg, #108e16, #084095);">
          <h5 class="mb-0">Important Announcements</h5>
        </div>
       <div class="announcement-container" style="display:hidden">
  <ul class="list-group list-group-flush announcements" >
    <li class="list-group-item">
      <img src="{{ asset('images/new_icon.gif') }}" alt="New" style="width: 30px; height: 12px; margin-right: 5px;">
      Inviting comments/suggestions on the guidelines for storage and handling of waste solar photo-voltaic modules or panels or cells
    </li>
    <li class="list-group-item">
      Timeline for filing annual returns for FY 2023-24 extended to <strong>31st Jan 2025</strong>.
    </li>
    <li class="list-group-item">Environmental Compensation (EC) Guidelines under E-Waste (M) Rules, 2022 and amendments</li>
    <li class="list-group-item">Public notice for recyclers dated 21.08.23</li>
    <li class="list-group-item">Instructions for creating login credentials (Sign-up) of the producer</li>
    <li class="list-group-item">Covering letter and undertaking for registration correctness</li>
    <li class="list-group-item">Signed declaration on producer company letterhead</li>
    <li class="list-group-item">Notice for Recyclers &amp; Refurbishers regarding CPCB guidelines</li>
    <li class="list-group-item">Notice for Recyclers</li>
    <li class="list-group-item">Notice for Producers</li>
    <li class="list-group-item">Registered recyclers notice under E-Waste EPR Portal</li>
    <li class="list-group-item">Letter to customs for release of consignments under E-Waste (M) Rules, 2022</li>
    <li class="list-group-item">Timeline for filing annual returns for FY 2023-24 extended to <strong>31st Aug 2024</strong>.</li>
  </ul>
</div>

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
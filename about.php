<?php
$pageTitle = 'About';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/header.php';
?>

<section class="py-5 bg-light rounded-4 mb-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <h1 class="display-6 fw-bold">Sustainable urban hydroponic farming for a greener tomorrow.</h1>
        <p class="lead text-muted mt-4">At Verdant Tech Farms, we bring smart, efficient indoor agriculture to cities, reducing water use, removing pesticides, and enabling year-round fresh produce.</p>
        <p class="text-muted">Our mission is to help growers and businesses flourish with reliable, energy-efficient hydroponic technology that fits modern urban spaces.</p>
      </div>
      <div class="col-lg-5 mt-4 mt-lg-0">
        <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-sm">
          <div class="bg-success bg-opacity-10 d-flex align-items-center justify-content-center text-success fw-bold">Hero image placeholder</div>
          <div><img src="uploads/Vardent.png" class="img-fluid rounded shadow" alt="Verdant Tech Hydroponic Farm"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="row gx-5 align-items-center mb-5">
      <div class="col-lg-6">
        <h2 class="h4 fw-semibold">Our Mission</h2>
        <p class="text-muted">We strive to reduce the environmental footprint of food production by offering compact hydroponic systems that use minimal water and eliminate pesticides.</p>
        <ul class="list-group list-group-flush">
          <li class="list-group-item border-0 px-0 py-2"><strong>Reduce water usage</strong> compared to conventional farming.</li>
          <li class="list-group-item border-0 px-0 py-2"><strong>Enable year-round local farming</strong> in urban environments.</li>
        </ul>
      </div>
      <div class="col-lg-6">
        <h2 class="h4 fw-semibold">Our Vision</h2>
        <p class="text-muted">To make sustainable indoor growing accessible through intelligent IoT systems that deliver precise climate control and nutrient management.</p>
        <ul class="list-group list-group-flush">
          <li class="list-group-item border-0 px-0 py-2"><strong>Smart IoT technology</strong> for automated and scalable growing.</li>
          <li class="list-group-item border-0 px-0 py-2"><strong>Healthy, pesticide-free crops</strong> for modern communities.</li>
        </ul>
      </div>
    </div>

    <div class="row text-center gy-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="mb-3 display-6 text-success">90%</div>
            <h5 class="card-title">Less Water</h5>
            <p class="card-text text-muted">Hydroponic systems consume up to 90% less water than soil-based agriculture.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="mb-3 display-6 text-success">100%</div>
            <h5 class="card-title">Pesticide-Free</h5>
            <p class="card-text text-muted">Our controlled environments keep produce clean and safe without harmful chemicals.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="mb-3 display-6 text-success">24/7</div>
            <h5 class="card-title">Automated Control</h5>
            <p class="card-text text-muted">Smart climate and nutrient systems help optimize yields around the clock.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="h4 fw-semibold">Leadership & Team</h2>
      <p class="text-muted">The team behind Verdant Tech Farms blends agriculture, engineering, and sustainable design.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 text-center p-4">
          <div class="rounded-circle bg-success bg-opacity-10 mx-auto mb-3" style="width:96px;height:96px; display:flex; align-items:center; justify-content:center;">
            <span class="text-success fw-bold">AD</span>
          </div>
          <h5 class="mb-1">Alex Dawson</h5>
          <p class="text-muted mb-0">Founder & CEO</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 text-center p-4">
          <div class="rounded-circle bg-success bg-opacity-10 mx-auto mb-3" style="width:96px;height:96px; display:flex; align-items:center; justify-content:center;">
            <span class="text-success fw-bold">MJ</span>
          </div>
          <h5 class="mb-1">Mina Jones</h5>
          <p class="text-muted mb-0">Head of Technology</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 text-center p-4">
          <div class="rounded-circle bg-success bg-opacity-10 mx-auto mb-3" style="width:96px;height:96px; display:flex; align-items:center; justify-content:center;">
            <span class="text-success fw-bold">RV</span>
          </div>
          <h5 class="mb-1">Ravi Verma</h5>
          <p class="text-muted mb-0">Operations Director</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>

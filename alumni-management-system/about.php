<?php
session_start();
include 'includes/header.php';
?>

<!-- ================= HERO SECTION ================= -->
<section class="about-hero">
  <div class="hero-overlay"></div>
  <div class="container text-center hero-content">
    <h1 class="hero-title">
      <i class="fa-solid fa-users me-2"></i>
      Stronger Together Beyond Graduation
    </h1>
    <p class="hero-subtitle">
      A powerful alumni network connecting students, graduates and the institute
      to build careers, mentorship and lifelong success.
    </p>
  </div>
</section>

<!-- ================= PURPOSE ================= -->
<section class="section-lg">
  <div class="container text-center">
    <h2 class="section-title mb-4">Why This Alumni Portal Exists</h2>
    <p class="section-text mx-auto">
      Alumni move across cities and industries, often losing touch with their roots.
      Meanwhile students seek guidance, industry exposure and career direction.
      This portal bridges that gap by creating a professional digital ecosystem
      for networking, mentoring and growth.
    </p>
  </div>
</section>

<!-- ================= BENEFITS ================= -->
<section class="section-lg bg-soft">
  <div class="container">
    <div class="row g-4">

      <div class="col-md-6">
        <div class="benefit-card">
          <h4><i class="fa-solid fa-user-graduate me-2"></i>For Alumni</h4>
          <ul>
            <li><i class="fa-solid fa-circle-check"></i> Expand professional network</li>
            <li><i class="fa-solid fa-circle-check"></i> Share job opportunities</li>
            <li><i class="fa-solid fa-circle-check"></i> Attend reunions & webinars</li>
            <li><i class="fa-solid fa-circle-check"></i> Mentor students</li>
            <li><i class="fa-solid fa-circle-check"></i> Showcase achievements</li>
          </ul>
        </div>
      </div>

      <div class="col-md-6">
        <div class="benefit-card">
          <h4><i class="fa-solid fa-lightbulb me-2"></i>For Students</h4>
          <ul>
            <li><i class="fa-solid fa-circle-check"></i> Career mentorship</li>
            <li><i class="fa-solid fa-circle-check"></i> Internship & job access</li>
            <li><i class="fa-solid fa-circle-check"></i> Industry insights</li>
            <li><i class="fa-solid fa-circle-check"></i> Alumni networking</li>
            <li><i class="fa-solid fa-circle-check"></i> Professional guidance</li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= TIRCHI ALUMNI SPOTLIGHT ================= -->
<section class="spotlight-section">
  <div class="container">
    <h2 class="text-center text-white mb-5">Alumni Spotlight</h2>

    <div class="row g-4 justify-content-center">

      <div class="col-md-3 spotlight-col tilt-left">
        <div class="spotlight-card">
          <div class="spotlight-avatar">
            <i class="fa-solid fa-user"></i>
          </div>
          <h5>Neha Verma</h5>
          <small>Software Engineer, Infosys</small>
        </div>
      </div>

      <div class="col-md-3 spotlight-col tilt-center">
        <div class="spotlight-card">
          <div class="spotlight-avatar">
            <i class="fa-solid fa-user"></i>
          </div>
          <h5>Rahul Singh</h5>
          <small>Project Manager</small>
        </div>
      </div>

      <div class="col-md-3 spotlight-col tilt-right">
        <div class="spotlight-card">
          <div class="spotlight-avatar">
            <i class="fa-solid fa-user"></i>
          </div>
          <h5>Priya Sharma</h5>
          <small>Pharmacist</small>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>

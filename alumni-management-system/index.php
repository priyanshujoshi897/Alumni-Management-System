<?php
session_start();
include "config/db.php";
include "includes/header.php";


/* ================= FETCH DATA ================= */

$alumniCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM alumni_profiles")
)['total'];

$jobCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM jobs")
)['total'];

$eventCount = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM events")
)['total'];
?>

<!-- ================= HERO SECTION ================= -->
<section class="hero-section">
  <div class="container">
    <h1 class="display-4 fw-bold">Alumni Management Portal</h1>
    <p class="lead mt-3">
      Stay Connected. Share Opportunities. Grow Together.
    </p>
    <a href="register.php" class="btn btn-outline-light btn-lg mt-4">
      Join the Network
    </a>
  </div>
</section>

<!-- ================= STATS ================= -->
<section class="stats-section">
  <div class="container">
    <div class="row text-center">

      <div class="col-md-4">
        <div class="stat-box">
          <h2 class="counter" data-target="<?php echo $alumniCount; ?>">0</h2>
          <p>Registered Alumni</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-box">
          <h2 class="counter" data-target="<?php echo $jobCount; ?>">0</h2>
          <p>Jobs Posted</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-box">
          <h2 class="counter" data-target="<?php echo $eventCount; ?>">0</h2>
          <p>Events Conducted</p>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ================= FEATURES ================= -->
<section style="padding:80px 0; background:#fffdf8;">
  <div class="container text-center">
    <h2 class="fw-bold mb-5">Platform Highlights</h2>

    <div class="row g-4">
      <div class="col-md-3 col-sm-6">
        <div class="feature-card">
          <h5>Alumni Directory</h5>
          <p>Search and connect with alumni across different batches and branches.</p>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="feature-card">
          <h5>Job Opportunities</h5>
          <p>Explore openings shared by alumni and apply easily.</p>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="feature-card">
          <h5>Events & Meets</h5>
          <p>Participate in reunions, seminars and webinars.</p>
        </div>
      </div>

      <div class="col-md-3 col-sm-6">
        <div class="feature-card">
          <h5>Discussion Forum</h5>
          <p>Share ideas, experiences and career advice.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= RECENT JOBS ================= -->
<section style="padding:80px 0;">
  <div class="container">
    <h2 class="fw-bold text-center mb-5">Latest Job Opportunities</h2>
    <div class="row g-4">

    <?php
    $jobs = mysqli_query($conn, "SELECT * FROM jobs ORDER BY id DESC LIMIT 3");

    if(mysqli_num_rows($jobs) > 0){
      while($row = mysqli_fetch_assoc($jobs)){
    ?>
      <div class="col-md-4">
        <div class="card p-4 h-100">

          <h5 class="fw-semibold">
            <?php echo htmlspecialchars($row['title']); ?>
          </h5>

          <p class="text-muted mb-1">
            <i class="fa-solid fa-building me-1"></i>
            <?php echo htmlspecialchars($row['company']); ?>
          </p>

          <p class="text-muted mb-1">
            <i class="fa-solid fa-location-dot me-1"></i>
            <?php echo htmlspecialchars($row['location']); ?>
          </p>

          <?php if(!empty($row['salary_package'])): ?>
            <p class="fw-semibold text-success mb-1">
              <i class="fa-solid fa-indian-rupee-sign me-1"></i>
              <?php echo htmlspecialchars($row['salary_package']); ?>
            </p>
          <?php endif; ?>

          <?php if(!empty($row['deadline'])): ?>
            <small class="text-danger">
              Deadline: <?php echo date("d M Y", strtotime($row['deadline'])); ?>
            </small>
          <?php endif; ?>

        </div>
      </div>
    <?php
      }
    } else {
      echo "<p class='text-center text-muted'>No jobs available.</p>";
    }
    ?>

    </div>
  </div>
</section>

<!-- ================= RECENT ALUMNI ================= -->
<section style="background:#f8f5ef; padding:80px 0;">
  <div class="container">
    <h2 class="fw-bold text-center mb-5">Recently Joined Alumni</h2>
    <div class="row g-4">

    <?php
    $alumni = mysqli_query($conn, "
      SELECT u.full_name, a.branch, a.batch_year
      FROM alumni_profiles a
      JOIN users u ON a.user_id = u.id
      ORDER BY a.id DESC
      LIMIT 3
    ");

    if(mysqli_num_rows($alumni) > 0){
      while($row = mysqli_fetch_assoc($alumni)){
    ?>
      <div class="col-md-4">
        <div class="card p-4 text-center">
          <h5><?php echo htmlspecialchars($row['full_name']); ?></h5>
          <p class="text-muted">
            <?php echo htmlspecialchars($row['branch']); ?> - 
            <?php echo htmlspecialchars($row['batch_year']); ?>
          </p>
        </div>
      </div>
    <?php
      }
    } else {
      echo "<p class='text-center text-muted'>No alumni registered yet.</p>";
    }
    ?>

    </div>
  </div>
</section>

<!-- ================= COUNTER SCRIPT ================= -->
<script>
const counters = document.querySelectorAll('.counter');

counters.forEach(counter => {
  const updateCount = () => {
    const target = +counter.getAttribute('data-target');
    const count = +counter.innerText;
    const increment = target / 100;

    if (count < target) {
      counter.innerText = Math.ceil(count + increment);
      setTimeout(updateCount, 20);
    } else {
      counter.innerText = target;
    }
  };
  updateCount();
});
</script>

<?php include "includes/footer.php"; ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Skolearn – Assignment System</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .hero {
      background: url('assets/img/bg-hero.png') no-repeat center center;
      color: white;
      padding: 100px 0;
    }

    .hero-img {
      max-width: 100%;
      border-radius: 12px;
    }

    .section-title {
      text-align: center;
      margin-top: 60px;
      font-weight: bold;
      color: #02b564;
    }

    .stats-icon {
      font-size: 40px;
      color: #02b564;
    }

    .card-glow:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    footer {
      background: #f8f9fa;
      padding: 20px 0;
      text-align: center;
      margin-top: 80px;
      color: #555;
    }
  </style>
</head>
<body>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-md-6 mb-4">
        <h1 class="display-4 fw-bold">Skolearn</h1>
        <p class="lead mt-3">Manage assignments online with ease. For lecturers and students who want a simple, fast, and effective task management experience.</p>
        <a href="login.php" class="btn btn-light btn-lg mt-4 me-2">Get Started</a>
        <a href="contact.php" class="btn btn-outline-light btn-lg mt-4">Reach Me</a>
      </div>
      
      <div class="col-md-6 d-flex justify-content-center">
        <img src="assets/img/hero-ilustration.png" alt="Hero Illustration" class="hero-img" width="50%">
      </div>
    </div>
  </div>
</section>

<!-- WHY SKOLEARN -->
<section>
  <div class="container">
    <h2 class="section-title">Why Choose Skolearn?</h2>
    <div class="row align-items-center mt-4">
      <div class="col-md-6">
        <p class="fs-5">Skolearn is a smart assignment platform where:</p>
        <ul class="fs-6">
          <li>📝 Lecturers can create, track, and evaluate student submissions</li>
          <li>📤 Students submit their work and see grading status instantly</li>
          <li>📊 Everything is managed in a simple web-based system</li>
        </ul>
        <a href="login.php" class="btn btn-success mt-3">Try Skolearn</a>
      </div>
      <div class="col-md-6 text-center d-flex justify-content-center">
        <img src="assets/img/learn.png" class="img-fluid rounded" alt="Students" width="40%">
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="mt-5">
  <div class="container">
    <div class="row text-center">
      <div class="col-md-3 mb-4">
        <div class="card border-0 card-glow">
          <div class="card-body">
            <div class="stats-icon">📚</div>
            <h5 class="mt-3 fw-bold">100+ Assignments</h5>
            <p>Created by lecturers</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card border-0 card-glow">
          <div class="card-body">
            <div class="stats-icon">👨‍🎓</div>
            <h5 class="mt-3 fw-bold">300+ Students</h5>
            <p>Actively submitting tasks</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card border-0 card-glow">
          <div class="card-body">
            <div class="stats-icon">✅</div>
            <h5 class="mt-3 fw-bold">900+ Submissions</h5>
            <p>Handled efficiently</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card border-0 card-glow">
          <div class="card-body">
            <div class="stats-icon">💬</div>
            <h5 class="mt-3 fw-bold">Instant Feedback</h5>
            <p>From lecturers to students</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <p>&copy; <?= date('Y') ?> Skolearn. All rights reserved.</p>
</footer>

</body>
</html>

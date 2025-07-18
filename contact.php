
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


</head>

<body>
    

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">CarRental</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link " href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="cars_public.php">Browse Cars</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
        <li class="nav-item"><a class="nav-link" href="user/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="user/register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- Hero Section -->
<section class="bg-dark text-white py-5 text-center">
  <div class="container">
    <h2 class="display-6">#let's_talk</h2>
    <p class="lead">LEAVE A MESSAGE, We love to hear from you!</p>
  </div>
</section>

<!-- Contact Details -->
<section class="py-5">
  <div class="container">
    <div class="row">
      <!-- Contact Info -->
      <div class="col-md-6">
        <h5 class="text-uppercase text-primary">Get In Touch</h5>
        <h3 class="mb-4">Visit one of our agency locations or contact us today</h3>
        <ul class="list-unstyled">
          <li class="mb-3"><i class="bi bi-geo-alt-fill me-2 text-primary"></i> 56 Glassford Street, Glasgow, NY</li>
          <li class="mb-3"><i class="bi bi-envelope-fill me-2 text-primary"></i> contact@example.com</li>
          <li class="mb-3"><i class="bi bi-telephone-fill me-2 text-primary"></i> +212 607119963</li>
          <li class="mb-3"><i class="bi bi-clock-fill me-2 text-primary"></i> Monday to Saturday: 9.00am to 4.00pm</li>
        </ul>
      </div>

      <!-- Google Map -->
      <div class="col-md-6">
        <div class="ratio ratio-4x3">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18... (same URL)" 
            style="border:0;" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Form -->
 <?php if (isset($_SESSION['msg'])): ?>
  <div class="alert alert-info">
    <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
  </div>
<?php endif; ?>

<section class="py-5 bg-light">
  <div class="container">
    <h3 class="text-center mb-4">We love to hear from you</h3>
<form action="contact_process.php" method="POST" class="contact-form">
  <div class="mb-3">
    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
  </div>
  <div class="mb-3">
    <input type="email" name="email" class="form-control" placeholder="Your Email" required>
  </div>
  <div class="mb-3">
    <input type="text" name="subject" class="form-control" placeholder="Subject" required>
  </div>
  <div class="mb-3">
    <textarea name="message" rows="5" class="form-control" placeholder="Your Message" required></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Send Message</button>
</form>

  </div>
</section>

<!-- Team Members -->
<section class="py-5">
  <div class="container">
    <h4 class="text-center mb-4">Our Team</h4>
    <div class="row justify-content-center">
      <?php for ($i = 1; $i <= 3; $i++): ?>
        <div class="col-md-4 text-center mb-4">
          <img src="assets/car.jpg?= $i ?>.png" class="rounded-circle mb-3" width="120" height="120" alt="Team Member">
          <h6 class="fw-bold">Abdo Charradi</h6>
          <p class="text-muted mb-1">Senior Marketing Manager</p>
          <p class="mb-1">Phone: +212 607119963</p>
          <p>Email: Abdocarradi@gmail.com</p>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- Newsletter -->
<section class="py-5 bg-dark text-white">
  <div class="container text-center">
    <h4 class="mb-3">Sign up For Newsletters</h4>
    <p class="mb-4">Get email updates about our latest cars and <span class="text-warning">special offers</span>.</p>
    <form class="row justify-content-center">
      <div class="col-auto">
        <a href="user/register.php"  class="btn btn-primary px-5">Sign Up</a>
      </div>
    </form>
  </div>
</section>



</body>
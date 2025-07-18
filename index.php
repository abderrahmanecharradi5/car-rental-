<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .hero {
      background: url('assets/car.jpg') no-repeat center center/cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-shadow: 0 2px 4px rgba(0,0,0,0.6);
      text-align: center;
      padding: 1rem;
    }
    @media (max-width: 768px) {
      .hero {
        height: auto;
        padding: 4rem 1rem;
      }
    }
    .footer {
      background-color: #343a40;
      color: #fff;
      padding: 40px 0;
    }
    .footer a {
      color: #ccc;
      text-decoration: none;
    }
    .footer a:hover {
      color: #fff;
    }
    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.6s ease-in-out;
    }
    .fade-in.show {
      opacity: 1;
      transform: none;
    }
  </style>
</head>
<body>

<!-- Header & Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">CarRental</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="cars_public.php">Browse Cars</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        <li class="nav-item"><a class="nav-link" href="user/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="user/register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section with Search -->
<section class="hero">
  <div class="container">
    <h1 class="display-3 fw-bold">Find Your Perfect Ride</h1>
    <p class="lead">Rent affordable, quality cars with ease and confidence.</p>
    <form action="user/cars.php" method="GET" class="row g-2 justify-content-center mt-4">
      <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="Search by brand, model...">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Search</button>
      </div>
    </form>
  </div>
</section>

<!-- Services Section -->
<section class="py-5 fade-in">
  <div class="container">
    <h2 class="text-center mb-5">Why Choose Us</h2>
    <div class="row text-center">
      <div class="col-md-4">
        <i class="bi bi-car-front fs-1 text-primary"></i>
        <h5 class="mt-3">Wide Selection</h5>
        <p>From economy to luxury, we offer a wide range of vehicles for all needs.</p>
      </div>
      <div class="col-md-4">
        <i class="bi bi-shield-lock fs-1 text-success"></i>
        <h5 class="mt-3">Secure & Insured</h5>
        <p>Full insurance coverage and 24/7 roadside assistance with every rental.</p>
      </div>
      <div class="col-md-4">
        <i class="bi bi-clock-history fs-1 text-warning"></i>
        <h5 class="mt-3">Flexible Booking</h5>
        <p>Rent anytime, anywhere. Modify or cancel your bookings easily.</p>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section class="bg-light py-5 fade-in">
  <div class="container text-center">
    <h3 class="mb-3">Ready to hit the road?</h3>
    <p>Sign up now and book your ride in minutes.</p>
    <a href="user/register.php" class="btn btn-success btn-lg">Create Account</a>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container text-center">
    <p>&copy; 2025 CarRental. All rights reserved.</p>
    <div class="mt-3">
      <a href="#" class="me-3"><i class="bi bi-facebook"></i></a>
      <a href="#" class="me-3"><i class="bi bi-twitter"></i></a>
      <a href="#"><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Scroll animation effect
  window.addEventListener('scroll', () => {
    document.querySelectorAll('.fade-in').forEach(el => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight - 100) {
        el.classList.add('show');
      }
    });
  });
</script>
</body>
</html>










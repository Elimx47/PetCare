<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Your One-Stop Pet Adoption and Medication Solution</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .hero-section {
            background: url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80') no-repeat center center;
            background-size: cover;
            height: 600px;
            position: relative;
        }

        .hero-content {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 10px;
        }

        .feature-icon {
            font-size: 3rem;
            color: #00CF00;
        }

        .testimonial-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }

        .navbar {
            background-color: #f7f7f7;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .nav-link {
            color: #666;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #333;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba%28255, 255, 255, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .dropdown-menu {
            padding: 0.5rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }

        .dropdown-item:hover {
            background-color: lightgreen;
        }

        .card-service{
            object-fit: cover;
            max-height: 275px;
            max-width: 415px;
            height:100%;
            width: 100%;
        }
    </style>
</head>

<body style="background-color: whitesmoke;">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://cdn-icons-png.flaticon.com/128/14029/14029433.png" alt="PetCare Logo" width="40" height="40" class="d-inline-block align-text-top me-2">
                PetCare
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('welcome') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pet-adopt') }}">Adoption</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('medication') }}">Medication</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                    @auth
                    <li class="nav-item me-2">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bg-danger ms-1">{{ $cartItemCount }}</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <!-- Profile Page Link -->
                            <a class="dropdown-item" href="{{ route('userProfile') }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>

                            <a class="dropdown-item" href="{{ route('userPets') }}">
                                <i class="fa-solid fa-paw me-2"></i>My Pets
                            </a>

                            <a class="dropdown-item" href="{{ route('user.adoption.applications') }}">
                                <i class="fa-solid fa-file-lines me-2"></i>My Applications
                            </a>

                            <a class="dropdown-item" href="{{ route('user.orders') }}">
                                <i class="fas fa-receipt me-2"></i> My Orders
                            </a>

                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Log in</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @endif
                    @endauth
                    @endif
                </ul>


            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="hero-content">
                        <h1 class="display-4 fw-bold">Welcome to PetCare</h1>
                        <p class="lead">Your one-stop solution for pet adoption and medication management. Find your perfect companion and keep them healthy with our comprehensive services.</p>
                        <a href="#services" class="btn btn-success btn-lg">Explore Our Services</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Services</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60" class="card-img-top card-service" alt="Adoption">
                        <div class="card-body">
                            <h5 class="card-title">Pet Adoption</h5>
                            <p class="card-text">Find your perfect pet from our wide range of available animals. We have dogs, cats, rabbits, and more!</p>
                            <a href="{{ route('pet-adopt') }}" class="btn btn-success">Browse Pets</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1512678080530-7760d81faba6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60" class="card-img-top card-service" alt="Medication">
                        <div class="card-body">
                            <h5 class="card-title">Buy Medication</h5>
                            <p class="card-text">Purchase high-quality medication to keep your pets healthy and happy. We offer a wide range of veterinary-approved products.</p>
                            <a href="{{ route('medication') }}" class="btn btn-success">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1581888227599-779811939961?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=60" class="card-img-top card-service" alt="Support">
                        <div class="card-body">
                            <h5 class="card-title">24/7 Support</h5>
                            <p class="card-text">We're here to help with any questions or concerns you may have. Our expert team is available around the clock.</p>
                            <a href="{{ route('contact') }}" class="btn btn-success">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Why Choose PetCare?</h2>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <i class="fas fa-heart feature-icon mb-3"></i>
                    <h4>Comprehensive Adoption Process</h4>
                    <p>Our adoption process is designed to match you with the perfect pet for your lifestyle and needs. We ensure a smooth transition for both you and your new companion.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-pills feature-icon mb-3"></i>
                    <h4>Quality Medication</h4>
                    <p>We offer a wide range of affordable, high-quality medication that's easy to purchase and delivered right to your door. All our products are vetted by licensed veterinarians.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-user-md feature-icon mb-3"></i>
                    <h4>Expert Advice</h4>
                    <p>Our team of experienced veterinarians and pet care specialists are always available to provide expert advice on pet health, nutrition, and behavior.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <img src="data:image/jpeg;base64,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" alt="Stepping Curry" class="testimonial-img mb-3">
                            <h5 class="card-title">Stephen Curry</h5>
                            <p class="card-text">"PetCare made adopting my furry friend so easy! Their support team was incredibly helpful throughout the process."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <img src="https://cdn.nba.com/headshots/nba/latest/1040x760/2544.png" alt="Michael Chen" class="testimonial-img mb-3">
                            <h5 class="card-title">Bronny James</h5>
                            <p class="card-text">"I love how convenient it is to order my pet's medication through PetCare. Fast delivery and great prices!"</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <img src="https://www.si.com/.image/ar_1:1%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cq_auto:good%2Cw_1200/MTY4MDI1MTYwNjg3MzYzMzQ1/kevin-durant-injury-update-achilles-tendon-surgeryjpg.jpg" alt="Emily Rodriguez" class="testimonial-img mb-3">
                            <h5 class="card-title">Kevin Durant</h5>
                            <p class="card-text">"The expert advice I received from PetCare's veterinarians was invaluable. They truly care about our pets' well-being."</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="bg-success text-white py-5">
        <div class="container text-center">
            <h2 class="mb-4">Ready to Find Your Perfect Pet?</h2>
            <p class="lead mb-4">Start your journey with PetCare today and give a loving home to a furry friend in need.</p>
            <a href="{{ route('pet-adopt') }}" class="btn btn-light btn-lg">Start Adoption Process</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About PetCare</h5>
                    <p>PetCare is dedicated to connecting loving homes with pets in need and providing top-quality pet care products and services.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('welcome') }}" class="text-white">Home</a></li>
                        <li><a href="{{ route('pet-adopt') }}" class="text-white">Adoption</a></li>
                        <li><a href="{{ route('medication') }}" class="text-white">Medication</a></li>
                        <li><a href="{{ route('about') }}" class="text-white">About</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <address>
                        <p><i class="fas fa-map-marker-alt me-2"></i> 123 Pet Street, Anytown, ST 12345</p>
                        <p><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                        <p><i class="fas fa-envelope me-2"></i> info@petcare.com</p>
                    </address>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2024 PetCare. All Rights Reserved.</p>
                <div class="mt-2">
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
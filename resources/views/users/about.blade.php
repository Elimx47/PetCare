<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - About Us</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            background: url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80') no-repeat center center;
            background-size: cover;
            height: 400px;
            position: relative;
        }

        .hero-content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .about-section {
            background-color: #f8f9fa;
            padding: 6rem 0;
        }

        .mission-vision-card {
            background-color: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .mission-vision-card .card-body {
            padding: 2rem;
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            background-color: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .icon-wrapper i {
            font-size: 2.5rem;
        }

        .team-carousel {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .team-carousel img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1.5rem;
            border: 5px solid #f8f9fa;
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

        .footer {
            background-color: #333;
            color: #fff;
            padding: 4rem 0 2rem;
        }

        .footer a {
            color: #fff;
            text-decoration: none;
        }

        .footer a:hover {
            color: #f8f9fa;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #333;
            border-radius: 50%;
            padding: 10px;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-control-prev-icon::before {
            content: '\f053';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: white;
        }

        .carousel-control-next-icon::before {
            content: '\f054';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: white;
        }
        .col-md-4{
            width: 25%;
        }

    </style>
</head>

<body>
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
                        <a class="nav-link " href="{{ route('welcome') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pet-adopt') }}">Adoption</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('medication') }}">Medication</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('about') }}">About</a>
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
                            <span class="badge bg-danger ms-1">{{ $cartItemCount}}</span>
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
                        <h1 class="display-4 fw-bold mb-4">About Us</h1>
                        <p class="lead">Discover our passion for pets and our commitment to their well-being. Learn about our mission, vision, and the dedicated team behind PetCare.</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6 mb-4">
                    <div class="mission-vision-card">
                        <div class="card-body text-center">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-paw text-primary"></i>
                            </div>
                            <h3 class="card-title text-primary mb-4">Our Mission</h3>
                            <p class="card-text">To ensure every pet finds a loving home and receives exceptional care, fostering a community that prioritizes pet well-being and responsible ownership.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="mission-vision-card">
                        <div class="card-body text-center">
                            <div class="icon-wrapper mb-4">
                                <i class="fas fa-heart text-success"></i>
                            </div>
                            <h3 class="card-title text-success mb-4">Our Vision</h3>
                            <p class="card-text">To be a leading advocate for animal welfare, transforming society's view on pets and creating a world where every animal is valued, cared for, and loved unconditionally.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Carousel -->
            <h2 class="text-center mb-5">Meet Our Dedicated Team</h2>
            <div id="teamCarousel" class="carousel slide team-carousel" data-bs-ride="carousel">
                
                        <div class="row text-center">
                            <div class="col-md-4">
                                <img src="https://cdn.discordapp.com/attachments/626778610992283669/1321472510625189888/469286789_2662178097323758_141968885426291571_n.png?ex=676d5cae&is=676c0b2e&hm=d355b1ccfd88784e2c95c8c4d5bfcc8741729194bfae54c6be2742a6bf6897ca&" alt="Evander Villanueva">
                                <h4 class="mb-2">Evander Villanueva</h4>
                                <p class="text-muted">Chief Veterinary Officer</p>
                            </div>
                            <div class="col-md-4">
                                <img src="https://cdn.discordapp.com/attachments/626778610992283669/1321472181896740884/82c53968-2484-415a-93ed-ed9ef038beef.png?ex=676d5c5f&is=676c0adf&hm=480f1d2f0f2a9af40979c4b4f8ee56620136c709efa1202953a62d5ccf5cb32b&" alt="John Drefner">
                                <h4 class="mb-2">Jan Drefner</h4>
                                <p class="text-muted">Adoption Coordinator</p>
                            </div>
                            <div class="col-md-4">
                                <img src="https://cdn.discordapp.com/attachments/626778610992283669/1321472400868507678/c7fa6420-6258-406f-adce-e72b92df3ac7.png?ex=676d5c94&is=676c0b14&hm=fe6257a11a34607233d8132c8ac3fea71915b27aecabcf6d07143abdb584d012&" alt="Mark Alicante">
                                <h4 class="mb-2">Mark Alicante</h4>
                                <p class="text-muted">Animal Nutrition Expert</p>
                            </div>
                            <div class="col-md-4">
                                <img src="https://cdn.discordapp.com/attachments/626778610992283669/1321472424830570496/3a04b3ad-46ad-4d36-bc77-7c6e4e09cc8a.png?ex=676d5c99&is=676c0b19&hm=aa41a1488ca2db0b7d62c7c2bd63666b9cef529bdb6c379e103e61552973d05e&" alt="Zyke Victoria">
                                <h4 class="mb-2">Zyke Victoria</h4>
                                <p class="text-muted">Shelter Operations Manager</p>
                            </div>
                        </div>


            </div>
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
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
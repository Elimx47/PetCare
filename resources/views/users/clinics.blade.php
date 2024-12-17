<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Veterinary Clinics</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* Copy the styles from the medications page */
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

        .hero-section {
            background: url('https://images.unsplash.com/photo-1512069772995-ec65ed45afd6?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80') no-repeat center center;
            background-size: cover;
            height: 300px;
            position: relative;
        }

        .hero-content {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 10px;
        }

        .medication-card {
            transition: transform 0.3s ease-in-out;
        }

        .medication-card:hover {
            transform: translateY(-5px);
        }

        .medication-img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar (Copy from medications page) -->
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
                        <a class="nav-link" href="{{ route('welcome') }}">Home</a>
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
                <!-- Authentication links from medications page -->
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                    @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('userProfile') }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>

                            <a class="dropdown-item" href="{{ route('userPets') }}">
                                <i class="fa-solid fa-paw me-2"></i> Pets
                            </a>

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
                        <h1 class="display-4 fw-bold">Veterinary Clinics</h1>
                        <p class="lead">Find trusted veterinary care near you. Quality healthcare for your beloved pets.</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Clinics Section -->
    <tion class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nearby Veterinary Clinics</h2>

            <!-- Clinic Cards -->
            <div class="row g-4" id="clinicCards">
                @forelse($clinics as $clinic)
                <div class="col-md-4 medication-card">
                    <div class="card h-100 shadow">
                        @if(isset($clinic['photos'][0]['photo_reference']))
                        <img src="{{ 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=' . $clinic['photos'][0]['photo_reference'] . '&key=' . config('services.google_maps.api_key') }}"
                            class="card-img-top medication-img" alt="{{ $clinic['name'] }}">
                        @else
                        <img src="https://via.placeholder.com/350x200.png?text=Vet+Clinic" class="card-img-top medication-img" alt="{{ $clinic['name'] }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $clinic['name'] }}</h5>
                            <p class="card-text">{{ Str::limit($clinic['vicinity'], 50) }}</p>
                            <p class="card-text">
                                <strong>Rating:</strong> {{ $clinic['rating'] ?? 'Not rated' }}/5
                            </p>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($clinic['name']) }}"
                                class="btn btn-success" target="_blank">View Details</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p>No veterinary clinics found nearby. Please try again or adjust your location settings.</p>
                </div>
                @endforelse
            </div>
        </div>
        </section>

        <!-- Footer (Copy from medications page) -->
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

        <!-- Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
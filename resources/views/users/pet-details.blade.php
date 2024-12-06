<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Adopt {{ $pets->name }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .hero-section {
            background-color: lightblue;
            background-size: cover;
            height: 300px;
            position: relative;
        }

        .pet-card {
            transition: transform 0.3s ease-in-out;
        }

        .pet-card:hover {
            transform: translateY(-5px);
        }

        .pet-img {
            height: 250px;
            object-fit: cover;
        }

        .navbar {
            background-color: #f7f7f7;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
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

        .pet-details-section {
            padding: 5rem 0;
        }

        .pet-details img {
            max-width: 100%;
            border-radius: 10px;
        }


        .hero-content {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            padding: 2rem;
            border-radius: 10px;
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
                        <a class="nav-link active" href="{{ route('pet-adopt') }}">Adoption</a>
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
                                <i class="fa-solid fa-paw me-2"></i> Pets
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
                        <h1 class="display-4 fw-bold">Adopt {{ $pets->name }}</h1>
                        <p class="lead">Meet {{ $pets->name }}, a lovely {{ $pets->breed }} who is looking for a forever home.</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Pet Details Section -->
    <section class="pet-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ Str::startsWith($pets->image, 'http') ? $pets->image : ($pets->image ? asset('storage/' . $pets->image) : asset('images/default-pet.jpg')) }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $pets->name }}">

                </div>
                <div class="col-md-6">
                    <h1 class="mb-4">{{ $pets->name }}</h1>
                    <p><strong>Breed:</strong> {{ $pets->breed }}</p>
                    <p><strong>Age:</strong> {{ $pets->age }} {{ $pets->age > 1 ? 'years' : 'year' }}</p>
                    <p><strong>Gender:</strong> {{ $pets->gender }}</p>

                    <p><strong>Health:</strong> {{ $pets->health }}</p>

                    <h4 class="mt-4">About {{ $pets->name }}</h4>
                    <p>{{ $pets->description }}</p>
                    @if ($pets->hasApplied)
                    <button class="btn btn-secondary btn-lg adopt-btn mt-4" disabled>Already Applied</button>
                    @else
                    <button type="button"
                        class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#adoptPetModal{{ $pets->id }}"
                        onclick="document.getElementById('petId').value = '{{ $pets->id }}'">
                        Adopt
                    </button>
                    @include('components.adoption-modal', ['pet' => $pets])
                    @endif
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

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open the existing modal
            var adoptPetModal = new bootstrap.Modal(document.getElementById('adoptPetModal{{ $pets->id }}'));
            adoptPetModal.show();
        });
    </script>
    @endif
</body>

</html>
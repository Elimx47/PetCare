<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Adopt a Pet</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .hero-section {
            background: url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80') no-repeat center center;
            background-size: cover;
            height: 300px;
            position: relative;
        }

        .hero-content {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 10px;
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

        .adoption-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .adoption-header h2 {
            margin: 0;
        }

        .adoption-header .btn {
            font-size: 1.1rem;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .btn-lg i {
            margin-right: 0.5rem;
        }

        .btn-lg {
            padding: 0.7rem 2rem;
        }

        .required-label::after {
            content: "*";
            color: red;
            margin-left: 4px;
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
                        <h1 class="display-4 fw-bold">Adopt a Pet</h1>
                        <p class="lead">Give a loving home to a furry friend in need. Browse our available pets and start your adoption journey today!</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Adoption Header (Button & Title) -->
    <div class="container mt-5 adoption-header">
        <h2>Available Pets for Adoption</h2>
        <a href="{{ route(name: 'userAddPet') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i>Add a Pet for Adoption
        </a>
    </div>



    <!-- Adoption Section -->
    <section class="py-5">
        <div class="container">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{session('success')}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="row g-4">
                @foreach($pets as $pet)
                <div class="col-md-4">
                    <div class="card h-100 shadow pet-card" data-pet-id="{{ $pet->id }}">
                        <img src="{{ Str::startsWith($pet->image, 'http') ? $pet->image : ($pet->image ? asset('storage/' . $pet->image) : asset('images/default-pet.jpg')) }}" class="card-img-top pet-img" alt="{{ $pet['name'] }}">

                        <div class="card-body">
                            <h5 class="card-title">{{ $pet->name }}</h5>
                            <p class="card-text">
                                <strong>Breed:</strong> {{ $pet->breed }}<br>
                                <strong>Age:</strong> {{ $pet->age }} {{ $pet->age > 1 ? 'years' : 'year' }}<br>
                                <strong>Gender:</strong> {{ $pet->gender }}
                            </p>
                            <p class="card-text">{{ Str::limit($pet->description, 100) }}</p>
                            <a href="{{ route('pets.show', $pet['id']) }}" class="btn btn-secondary">View Details</a>
                            @if ($pet->hasApplied)
                            <button class="btn btn-secondary" disabled>Already Applied</button>
                            @elseif ($pet->isUploadedByCurrentUser)
                            <a href="{{ route('userEditPet', ['id' => $pet->id]) }}" class="btn btn-primary">
                                Edit Pet Details
                            </a>
                            @else
                            <button type="button"
                                class="btn btn-success"
                                data-bs-toggle="modal"
                                data-bs-target="#adoptPetModal{{ $pet->id }}"
                                onclick="document.getElementById('petId').value = '{{ $pet->id }}'">
                                Adopt
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @include('components.adoption-modal', ['pet' => $pet])
                @endforeach
            </div>
            <br>
            {{ $pets->links('pagination::bootstrap-5') }}
        </div>

    </section>

    <!-- Adoption Process -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Adoption Process</h2>
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <i class="fas fa-search fa-3x text-success mb-3"></i>
                    <h4>1. Browse</h4>
                    <p>Look through our available pets and find your perfect match.</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                    <h4>2. Apply</h4>
                    <p>Submit your application and tell us why you're a great fit.</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-heart fa-3x text-success mb-3"></i>
                    <h4>3. Meet & Greet</h4>
                    <p>Schedule a meeting with the pet to make sure it's the right match.</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-home fa-3x text-success mb-3"></i>
                    <h4>4. Welcome Home</h4>
                    <p>Bring your new friend home and enjoy your life together!</p>
                </div>
            </div>
        </div>
    </section>


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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Only open the modal for the pet that was being applied for
            const petId = "{{ old('pet_id') }}";
            if (petId) {
                const modalElement = document.getElementById('adoptPetModal' + petId);
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        });
    </script>
    @endif
</body>

</html>
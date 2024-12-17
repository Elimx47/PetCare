<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Edit Pet Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <style>
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

        .form-section {
            background-color: #f8f9fa;
            padding: 3rem 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                        <h1 class="display-4 fw-bold">Edit Pet Details</h1>
                        <p class="lead">Update the information for {{ $pets->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Edit Pet Form Section -->
    <section class="form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-container">
                        <h2 class="text-center mb-4">Edit Pet Information</h2>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{ route('user-update-pet', ['id' => $pets->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="petName" class="form-label">Pet Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="petName" name="name" value="{{ old('name', $pets->name) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="petType" class="form-label">Pet Type</label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="petType" name="type">
                                        <option value="Dog" {{ old('type', $pets->type) == 'Dog' ? 'selected' : '' }}>Dog</option>
                                        <option value="Cat" {{ old('type', $pets->type) == 'Cat' ? 'selected' : '' }}>Cat</option>
                                        <option value="Bird" {{ old('type', $pets->type) == 'Bird' ? 'selected' : '' }}>Bird</option>
                                        <option value="Rabbit" {{ old('type', $pets->type) == 'Rabbit' ? 'selected' : '' }}>Rabbit</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="petBreed" class="form-label">Breed</label>
                                    <input type="text" class="form-control @error('breed') is-invalid @enderror" id="petBreed" name="breed" value="{{ old('breed', $pets->breed) }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="petAge" class="form-label">Age</label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror" id="petAge" name="age" value="{{ old('age', $pets->age) }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="petGender" class="form-label">Gender</label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="petGender" name="gender">
                                        <option value="Male" {{ old('gender', $pets->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $pets->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="petDescription" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="petDescription" name="description" rows="4">{{ old('description', $pets->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="petHealth" class="form-label">Pet Health</label>
                                <textarea class="form-control @error('health') is-invalid @enderror" id="petHealth" name="health" rows="4">{{ old('health', $pets->health) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="petImage" class="form-label">Pet Image (Optional)</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="petImage" name="image">
                                @if($pets->image)
                                <div class="mt-2">
                                    <small>Current Image:</small>
                                    <img src="{{ Str::startsWith($pets->image, 'http') ? $pets->image : asset('storage/' . $pets->image) }}" alt="{{ $pets->name }}" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                                @endif
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Update Pet Details</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <!-- Copy the existing footer from the add pet form -->
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
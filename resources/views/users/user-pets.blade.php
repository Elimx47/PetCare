<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - My Pets</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .pet-card {
            text-decoration: none;
            transition: transform 0.2s ease;
        }

        .pet-card:hover {
            transform: scale(1.03);
        }


        .pet-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
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

        .status-badge {
            font-size: 0.875rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background-color: #def7ec;
            color: #03543f;
        }

        .status-not-approved {
            background-color: #fde8e8;
            color: #9b1c1c;


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
    </style>
</head>

<body class="bg-light">
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

    <div class="container py-5">
        <h1 class="h2 fw-bold text-gray-800">My Pets</h1>
        <p class="text-muted">Manage your uploaded pets for adoption</p>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($pets->isEmpty())
        <div class="text-center bg-white rounded-3 shadow-sm p-5">
            <p class="text-muted mb-4">You haven't uploaded any pets for adoption yet.</p>
            <a href="{{ route('userAddPet') }}" class="btn btn-primary px-4">Add a Pet</a>
        </div>
        @else
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($pets as $pet)
            <div class="col">
                <a href="{{ route('pets.show', $pet->id) }}" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="row g-0 h-100">
                            <div class="col-md-4" style="height: 200px;">
                                @if($pet->image)
                                <img src="{{ Str::startsWith($pet->image, 'http') ? $pet->image : asset('storage/' . $pet->image) }}"
                                    class="img-fluid w-100 h-100 object-fit-cover"
                                    alt="{{ $pet->name }}">
                                @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center h-100">
                                    <span class="text-white fs-4">No Image</span>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $pet->name }}</h5>
                                    <p class="card-text">{{ $pet->breed }}</p>
                                    <div class="mb-2">
                                        <span class="badge bg-primary text-white me-2">{{ $pet->age }} {{ Str::plural('year', $pet->age) }}</span>
                                        <span class="badge bg-warning text-dark">{{ $pet->gender }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="status-badge {{ $pet->status === 'Pending' ? 'status-pending' : 'status-approved' }} me-3">
                                            <i class="fa {{ $pet->status === 'Pending' ? 'fa-clock' : 'fa-check-circle' }} me-1"></i>
                                            Adopted: {{ $pet->status }}
                                        </span>
                                        <span class="status-badge {{ $pet->approved ? 'status-approved' : 'status-not-approved' }}">
                                            <i class="fa {{ $pet->approved ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                            Approved: {{ $pet->approved ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                    <p class="card-text"><small class="text-body-secondary">Created at {{$pet->created_at}}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $pets->links() }}</div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
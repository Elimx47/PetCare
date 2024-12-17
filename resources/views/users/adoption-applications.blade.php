<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .navbar {
            background-color: #f7f7f7;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
        }

        .table-container {
            margin: 0 auto;
            padding: 0 2rem;
            max-width: 1300px;
            margin-top: 25px;
        }

        .pet-thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
        }

        .pet-info {
            display: flex;
            align-items: center;
        }

        .modal-body img {
            max-width: 100%;
            height: auto;
        }

        .document-preview {
            width: 100%;
            height: 500px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .table> :not(caption)>*>* {
            padding: 1rem;
            vertical-align: middle;
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

        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
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
                        <a class="nav-link" href="{{ route('welcome') }}">Home</a>
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

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">My Adoption Applications</h3>
            </div>
            <div class="card-body">
                @if($applications->isEmpty())
                <div class="alert alert-info text-center">
                    <p>You haven't submitted any adoption applications yet.</p>
                    <a href="{{ route('pet-adopt') }}" class="btn btn-primary mt-2">
                        Browse Pets for Adoption
                    </a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Pet</th>
                                <th>Application Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applications as $application)
                            <tr>
                                <td>
                                    <div class="pet-info">
                                        <img src="{{ Str::startsWith($application->pet->image, 'http') ? $application->pet->image : ($application->pet->image ? asset('storage/' . $application->pet->image) : asset('images/default-pet.jpg')) }}"
                                            alt="{{ $application->pet->name }}"
                                            class="pet-thumbnail">
                                        <div>
                                            <strong>{{ $application->pet->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $application->pet->breed }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                @if($application->pet->status == 'Pending')
                                <td>
                                    <h5><span class="badge rounded-pill
                                        @if($application->status == 'Pending') text-bg-warning
                                        @elseif($application->status == 'Approved') text-bg-success
                                        @elseif($application->status == 'Rejected') text-bg-danger
                                        @endif ">
                                            {{ $application->status }}
                                        </span></h5>
                                </td>
                                @elseif($application->pet->status== 'Adopted')
                                <td>
                                    <h5><span class="badge rounded-pill text-bg-info">
                                            Adopted by other user
                                        </span></h5>
                                </td>
                                @endif
                                <td>
                                    <div class="dropdown position-static">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $application->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $application->id }}">
                                            <li>
                                                <a href="{{ route('pets.show', $application->pet->id) }}" class="dropdown-item">
                                                    <i class="fas fa-eye me-2"></i> View Pet
                                                </a>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#documentsModal{{ $application->id }}">
                                                    <i class="fas fa-file me-2"></i> View Documents
                                                </button>
                                            </li>
                                            @if($application->status == 'Pending')
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#cancelApplicationModal{{ $application->id }}">
                                                    <i class="fas fa-times-circle me-2"></i> Cancel Application
                                                </button>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>

                                    <!-- Documents Modal -->
                                    <div class="modal fade" id="documentsModal{{ $application->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Application Documents</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-bs-toggle="tab" href="#idProof{{ $application->id }}">ID Proof</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#incomeProof{{ $application->id }}">Income Proof</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content mt-3">
                                                        <div class="tab-pane fade show active" id="idProof{{ $application->id }}">
                                                            <iframe src="{{ asset('storage/' . $application->id_proof_path) }}"
                                                                class="document-preview"></iframe>
                                                            <a href="{{ asset('storage/' . $application->id_proof_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Open in New Tab
                                                            </a>
                                                        </div>
                                                        <div class="tab-pane fade" id="incomeProof{{ $application->id }}">
                                                            <iframe src="{{ asset('storage/' . $application->income_proof_path) }}"
                                                                class="document-preview"></iframe>
                                                            <a href="{{ asset('storage/' . $application->income_proof_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Open in New Tab
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cancel Application Modal -->
                                    <div class="modal fade" id="cancelApplicationModal{{ $application->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Cancel Adoption Application</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to cancel your adoption application for <strong>{{ $application->pet->name }}</strong>?</p>
                                                    <p class="text-muted">This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <form action="{{ route('adoption.cancel', $application->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Confirm Cancel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
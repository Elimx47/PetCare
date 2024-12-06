<x-app-layout>
    <style>
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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-3xl font-semibold mb-4 text-gray-800">Manage Adoption Applications</h1>

                        <!-- Search Bar -->
                        <div class="d-flex justify-content-end align-items-end mb-4">
                            <form action="{{ route('admin.adoption.manage') }}" method="GET" class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search applications by pet name, user, or status..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Success & Error Messages -->
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Adoption Applications Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Application ID</th>
                                        <th>Pet Name</th>
                                        <th>Applicant Name</th>
                                        <th>Contact Number</th>
                                        <th class="text-center">Actions</th>
                                        <th class="text-center">Status</th>
                                        <th>Application Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($applications->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">No adoption applications found.</td>
                                    </tr>
                                    @else
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>{{ $application->id }}</td>
                                        <td>{{ $application->pet->name }}</td>
                                        <td>{{ $application->full_name }}</td>
                                        <td>{{ $application->contact_number }}</td>
                                        <td class="text-center">
                                            <div class="dropdown position-static">
                                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton{{ $application->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $application->id }}">
                                                    <li>
                                                        <a href="{{ asset('storage/' . $application->id_proof_path) }}"
                                                            target="_blank"
                                                            class="dropdown-item">
                                                            <i class="bi bi-file-earmark-person"></i> View ID Proof
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ asset('storage/' . $application->income_proof_path) }}"
                                                            target="_blank"
                                                            class="dropdown-item">
                                                            <i class="bi bi-file-earmark-text"></i> View Income Proof
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#applicationDetailsModal{{ $application->id }}">
                                                            <i class="bi bi-info-circle"></i> View Details
                                                        </button>
                                                    </li>
                                                    @if($application->status == 'Pending')
                                                    <li>
                                                        <form action="{{ route('admin.adoption.approve', $application->id) }}" method="POST" class="dropdown-item">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-link p-0 text-success">
                                                                <i class="bi bi-check-circle"></i> Approve
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.adoption.reject', $application->id) }}" method="POST" class="dropdown-item">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-link p-0 text-danger">
                                                                <i class="bi bi-x-circle"></i> Reject
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge 
                                                @if($application->status == 'Pending') bg-warning 
                                                @elseif($application->status == 'Approved') bg-success 
                                                @elseif($application->status == 'Rejected') bg-danger 
                                                @endif">
                                                {{ $application->status }}
                                            </span>
                                        </td>
                                        <td>{{ $application->created_at->diffForHumans() }}</td>
                                    </tr>

                                    <!-- Application Details Modal -->
                                    <div class="modal fade" id="applicationDetailsModal{{ $application->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Adoption Application Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h5>Applicant Information</h5>
                                                            <p><strong>Full Name:</strong> {{ $application->full_name }}</p>
                                                            <p><strong>Contact Number:</strong> {{ $application->contact_number }}</p>
                                                            <p><strong>Address:</strong> {{ $application->address }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5>Pet Information</h5>
                                                            <p><strong>Pet Name:</strong> {{ $application->pet->name }}</p>
                                                            <p><strong>Health:</strong> {{ $application->pet->health }}</p>
                                                            <p><strong>Breed:</strong> {{ $application->pet->breed }}</p>
                                                        </div>
                                                    </div>
                                                    @if($application->additional_info)
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h6>Additional Information</h6>
                                                            <p>{{ $application->additional_info }}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $applications->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</x-app-layout>
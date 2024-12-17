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

        .document-preview {
            width: 100%;
            height: 500px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .nav-tabs .nav-link.active {
            background-color: #f8f9fa;
            border-color: #dee2e6 #dee2e6 #f8f9fa;
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
                                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#documentsModal{{ $application->id }}">
                                                            <i class="bi bi-file-earmark-text"></i> View Documents
                                                        </button>
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
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title text-primary">
                                                        <i class="bi bi-person-vcard me-2"></i>Adoption Application Details
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row g-4">
                                                        <div class="col-md-6">
                                                            <div class="card h-100 border-primary">
                                                                <div class="card-header bg-primary text-white">
                                                                    <i class="bi bi-person-lines-fill me-2"></i>Applicant Information
                                                                </div>
                                                                <div class="card-body">
                                                                    <p class="mb-2"><strong>Full Name:</strong> {{ $application->full_name }}</p>
                                                                    <p class="mb-2"><strong>Contact Number:</strong> {{ $application->contact_number }}</p>
                                                                    <p class="mb-0"><strong>Address:</strong> {{ $application->address }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card h-100 border-success">
                                                                <div class="card-header bg-success text-white">
                                                                    <i class="bi bi-info-circle me-2"></i>Pet Information
                                                                </div>
                                                                <div class="card-body">
                                                                    <p class="mb-2"><strong>Pet Name:</strong> {{ $application->pet->name }}</p>
                                                                    <p class="mb-2"><strong>Health:</strong> {{ $application->pet->health }}</p>
                                                                    <p class="mb-0"><strong>Breed:</strong> {{ $application->pet->breed }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($application->additional_info)
                                                    <div class="card mt-3 border-warning">
                                                        <div class="card-header bg-warning text-dark">
                                                            <i class="bi bi-info-square me-2"></i>Additional Information
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="mb-0">{{ $application->additional_info }}</p>
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
                                                            <iframe src="{{ asset('storage/' . $application->id_proof_path) }}" class="document-preview"></iframe>
                                                            <div class="mt-2">
                                                                <a href="{{ asset('storage/' . $application->id_proof_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                    <i class="bi bi-box-arrow-up-right"></i> Open in New Tab
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="incomeProof{{ $application->id }}">
                                                            <iframe src="{{ asset('storage/' . $application->income_proof_path) }}" class="document-preview"></iframe>
                                                            <div class="mt-2">
                                                                <a href="{{ asset('storage/' . $application->income_proof_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                    <i class="bi bi-box-arrow-up-right"></i> Open in New Tab
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
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
<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-3xl font-semibold mb-4 text-gray-800">Manage Pet Adoptions</h1>

                        <!-- Search Bar -->


                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex">
                                <a href="{{ route('adminAddPet') }}" class="btn btn-primary me-2" title="Add Pet">
                                    <i class="bi bi-plus-circle me-2"></i>Add Pet
                                </a>
                                <a href="{{ route('archivedPets') }}" class="btn btn-secondary me-2" title="View Archived Pets">
                                    <i class="bi bi-archive me-2"></i>View Archived Pets
                                </a>
                            </div>
                            <form action="{{ route('pet-manage') }}" method="GET" class="col-md-6">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control form-control" placeholder="Search pets by name, breed, or status..." value="{{ request('search') }}">
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

                        <!-- Pet Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pet ID</th>
                                        <th>Pet Name</th>
                                        <th>Created by</th>
                                        <th class="text-center">Actions</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Approved?</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($pets->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">No pets found.</td>
                                    </tr>
                                    @else
                                    @foreach($pets as $pet)
                                    <tr>
                                        <td>{{ $pet->id }}</td>
                                        <td>{{ $pet->name }}</td>
                                        <td>{{ $pet->user->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin-pets.show', ['id' => $pet->id]) }}" class="btn btn-info btn-sm" title="Show Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('adminEditPet', ['id' => $pet->id]) }}" class="btn btn-warning btn-sm" title="Edit"
                                                @if($pet->status == 'Adopted') style="pointer-events: none; opacity: 0.5;" @endif>
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('adminDeletePet', ['id' => $pet->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Archive"
                                                    onclick="return confirm('Are you sure you want to archive this pet?');"
                                                    @if($pet->status == 'Adopted') disabled @endif>
                                                    <i class="bi bi-archive"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $pet->status === 'Adopted' ? 'success' : 'secondary' }}">
                                                {{ $pet->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $pet->approved === 1 ? 'success' : 'danger' }}">
                                                {{ $pet->approved === 1 ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>{{ $pet->created_at->diffForHumans() }}</td>
                                        <td>{{ $pet->updated_at ? $pet->updated_at->diffForHumans() : 'Not yet updated' }}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $pets->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
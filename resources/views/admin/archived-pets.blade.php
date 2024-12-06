<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-3xl font-semibold mb-4 text-gray-800">Archived Pets</h1>

                        <div class="mb-4">
                            <a href="{{ route('pet-manage') }}" class="btn btn-primary" title="Back to Active Pets">
                                <i class="bi bi-arrow-left me-2"></i>Back to Active Pets
                            </a>
                        </div>

                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{session('success')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{session('error')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pet ID</th>
                                        <th>Pet Name</th>
                                        <th>Created by</th>
                                        <th class="text-center">Actions</th>
                                        <th>Archived at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($archivedPets as $pet)
                                    <tr>
                                        <td>{{ $pet->id }}</td>
                                        <td>{{ $pet->name }}</td>
                                        <td>{{ $pet->user->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin-pets.show', ['id' => $pet->id]) }}" class="btn btn-info btn-sm" title="Show Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('adminRestorePet', ['id' => $pet->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('Are you sure you want to restore this pet?');">
                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('adminPermanentDeletePet', ['id' => $pet->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Permanently Delete" onclick="return confirm('Are you sure you want to permanently delete this pet? This action cannot be undone.');">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>{{ $pet->deleted_at->diffForHumans() }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $archivedPets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
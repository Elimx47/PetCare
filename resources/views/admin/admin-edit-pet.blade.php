<style>
    .card {
        border-radius: 0.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>

<x-app-layout>
    <section class="form-section">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center mb-4 fw-bold" style="font-size: 2rem;">Edit Pet Information</h2>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (session('info'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>{{session('info')}}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form action="{{ route('adminUpdatePet', ['id' => $pets->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="petName" class="form-label">Pet Name</label>
                                        <input type="text" class="form-control" id="petName" name="name" value="{{ $pets->name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="petType" class="form-label">Type</label>
                                        <input type="text" class="form-control" id="petType" name="type" value="{{ $pets->type }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="petBreed" class="form-label">Breed</label>
                                        <input type="text" class="form-control" id="petBreed" name="breed" value="{{ $pets->breed }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="petAge" class="form-label">Age</label>
                                        <input type="number" class="form-control" id="petAge" name="age" value="{{ $pets->age }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="petGender" class="form-label">Gender</label>
                                        <select class="form-select" id="petGender" name="gender" required>
                                            <option value="Male" {{ $pets->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ $pets->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="petStatus" class="form-label">Status</label>
                                        <select class="form-select" id="petStatus" name="status" style="pointer-events: none;">
                                            <option value="Pending" {{ $pets->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Adopted" {{ $pets->status == 'Adopted' ? 'selected' : '' }}>Adopted</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label d-block">Approval</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="petApproval" name="approval" value="Approved" {{ $pets->approved == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="petApproval">Approved</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="petDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="petDescription" name="description" rows="4" required>{{ $pets->description }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="petHealth" class="form-label">Pet Health</label>
                                    <textarea class="form-control @error('health') is-invalid @enderror" id="petHealth" name="health" rows="4">{{ $pets->health }}</textarea>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="petImage" class="form-label">Pet Image</label>

                                        <!-- Display current pet image if it exists -->
                                        @if($pets->image)
                                        <div class="mb-2">
                                            <img src="{{ Str::startsWith($pets->image, 'http') ? $pets->image : ($pets->image ? asset('storage/' . $pets->image) : asset('images/default-pet.jpg')) }}" class="img-fluid rounded-start" alt="{{ $pets->name }}" width="150" height="150">
                                        </div>
                                        @endif

                                        <!-- File input for uploading new image -->
                                        <input type="file" class="form-control" id="petImage" name="image" hidden>
                                    </div>
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-lg">Update Pet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
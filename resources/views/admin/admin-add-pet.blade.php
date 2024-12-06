<style>
    .card {
        border-radius: 0.5rem;
        /* Rounded corners for a softer look */
    }

    .form-label {
        font-weight: 500;
        /* Slightly bolder labels for emphasis */
        color: #333;
        /* Darker text for better readability */
    }

    .btn-success {
        background-color: #28a745;
        /* Use Bootstrap's success color */
        border: none;
        /* Remove border */
    }
</style>

<x-app-layout>
    <section class="form-section">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center mb-4 fw-bold" style="font-size: 2rem;">Pet Information</h2>
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form action="{{route('store.post')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="petName" class="form-label">Pet Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="petName" name="name" value="{{ old('name') }}">
                                    </div>
                                    <div class=" col-md-6">
                                        <label for="petType" class="form-label">Pet Type</label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="petType" name="type" value="{{ old('type') }}">
                                            <option value="">Select pet type</option>
                                            <option value="Dog">Dog</option>
                                            <option value="Cat">Cat</option>
                                            <option value="Bird">Bird</option>
                                            <option value="Rabbit">Rabbit</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="petBreed" class="form-label">Breed</label>
                                        <input type="text" class="form-control @error('breed') is-invalid @enderror" id="petBreed" name="breed" value="{{ old('breed') }}">
                                    </div>
                                    <div class=" col-md-3">
                                        <label for="petAge" class="form-label">Age</label>
                                        <input type="number" class="form-control @error('age') is-invalid @enderror" id="petAge" name="age" value="{{ old('age') }}">
                                    </div>
                                    <div class=" col-md-3">
                                        <label for="petGender" class="form-label">Gender</label>
                                        <select class="form-select @error('gender') is-invalid @enderror" id="petGender" name="gender" value="{{ old('gender') }}">
                                            <option value="">Select gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="petDescription" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="petDescription" name="description" rows="4">{{ old('description') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="petHealth" class="form-label">Pet Health</label>
                                    <textarea class="form-control @error('health') is-invalid @enderror" id="petHealth" name="health" rows="4">{{ old('health') }}</textarea>
                                </div>

                                <div class=" mb-3">
                                    <label for="petImage" class="form-label">Pet Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="petImage" name="image" value="{{ old('image') }}">
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-lg">Submit Pet for Adoption</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</x-app-layout>
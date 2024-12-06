<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="row g-0">
                        <!-- Pet Image -->
                        <div class="col-md-6">
                            <img src="{{ Str::startsWith($pets->image, 'http') ? $pets->image : ($pets->image ? asset('storage/' . $pets->image) : asset('images/default-pet.jpg')) }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $pets->name }}">
                        </div>
                        <!-- Pet Information -->
                        <div class="col-md-6">
                            <div class="card-body d-flex flex-column h-100">
                                <h2 class="card-title h3 mb-4">{{ $pets->name }}</h2>
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2"><span class="text-muted">Type:</span> <span class="fw-medium">{{ $pets->type }}</span></li>
                                    <li class="mb-2"><span class="text-muted">Breed:</span> <span class="fw-medium">{{ $pets->breed }}</span></li>
                                    <li class="mb-2"><span class="text-muted">Age:</span> <span class="fw-medium">{{ $pets->age }} {{ $pets->age > 1 ? 'years' : 'year' }}</span></li>
                                    <li class="mb-2"><span class="text-muted">Gender:</span> <span class="fw-medium">{{ $pets->gender }}</span></li>
                                    <li class="mb-2"><span class="text-muted">Health:</span> <span class="fw-medium">{{ $pets->health }}</span></li>
                                </ul>
                                <div class="mt-auto">
                                    <h5 class="h6 text-muted mb-2">About {{ $pets->name }}</h5>
                                    <p class="card-text">{{ $pets->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
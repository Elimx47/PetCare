<div class="modal fade" id="adoptPetModal{{ $pet->id }}" tabindex="-1" aria-labelledby="adoptPetModalLabel{{ $pet->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="adoptPetModalLabel{{ $pet->id }}">Adoption Application for {{$pet->name}}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @if ($errors->any() && old('pet_id') == $pet->id)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oops! There were some issues with your submission:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form id="adoptionForm{{ $pet->id }}" action="{{ route('submit.adoption') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="pet_id" value="{{ $pet->id }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fullName{{ $pet->id }}" class="form-label required-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName{{ $pet->id }}" name="full_name"
                                value="{{ Auth::check() ? Auth::user()->name : old('full_name') }}"
                                {{ Auth::check() ? 'readonly' : '' }}>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contactNumber{{ $pet->id }}" class="form-label required-label">Contact Number</label>
                            <input type="tel" class="form-control" id="contactNumber{{ $pet->id }}" name="contact_number" value="{{ old('contact_number') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address{{ $pet->id }}" class="form-label required-label">Home Address</label>
                        <textarea class="form-control" id="address{{ $pet->id }}" name="address" rows="3">{{ old('address') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="idProof{{ $pet->id }}" class="form-label required-label">Government ID</label>
                            <input type="file" class="form-control" id="idProof{{ $pet->id }}" name="id_proof" accept="image/jpeg,image/png,image/jpg">
                            <small class="form-text text-muted">Upload a clear image of your government-issued ID (JPG, PNG)</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="incomeProof{{ $pet->id }}" class="form-label required-label">Income Proof</label>
                            <input type="file" class="form-control" id="incomeProof{{ $pet->id }}" name="income_proof" accept="application/pdf">
                            <small class="form-text text-muted">Upload a PDF of your income proof (pay slip, tax return)</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="additionalInfo{{ $pet->id }}" class="form-label">Additional Information</label>
                        <textarea class="form-control" id="additionalInfo{{ $pet->id }}" name="additional_info" rows="3" placeholder="Why do you want to adopt {{ $pet->name }}? (Optional)">{{ old('additional_info') }}</textarea>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        By submitting this form, you agree to a background check and potential home visit.
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit Adoption Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
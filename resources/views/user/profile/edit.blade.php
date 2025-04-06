@extends('user.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="profile-photo-container mb-3">
                        <img src="{{ asset(auth()->user()->photo ?? 'images/default-avatar.png') }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="img-fluid rounded-circle profile-photo" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h5 class="card-title">{{ auth()->user()->name }}</h5>
                    <p class="text-muted small">{{ auth()->user()->email }}</p>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#updatePhotoModal">
                        <i class="bi bi-camera"></i> Change Photo
                    </button>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#profile-view" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                        <i class="bi bi-person me-2"></i> Profile Information
                    </a>
                    <a href="#profile-edit" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="bi bi-pencil-square me-2"></i> Edit Profile
                    </a>
                    <a href="#security-edit" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="bi bi-shield-lock me-2"></i> Security
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="tab-content">
                        <!-- Profile View Tab -->
                        <div class="tab-pane fade show active" id="profile-view">
                            <h4 class="mb-4">{{ auth()->user()->name }}</h4>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="text-muted small mb-0">Email</label>
                                    <p class="mb-3">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small mb-0">Phone</label>
                                    <p class="mb-3">{{ auth()->user()->phone ?? 'N/A' }}</p>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small mb-0">Address</label>
                                    <p class="mb-0">{{ auth()->user()->address ?? 'N/A' }}</p>
                                    <p class="mb-0">{{ auth()->user()->city ?? '' }} {{ auth()->user()->postal_code ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Edit Tab -->
                        <div class="tab-pane fade" id="profile-edit">
                            <form id="profile-form">
                                @csrf
                                <!-- Existing form fields -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ auth()->user()->name }}">
                                        <div class="invalid-feedback" id="name-error"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="{{ auth()->user()->email }}">
                                        <div class="invalid-feedback" id="email-error"></div>
                                    </div>
                                </div>
                                <!-- Additional fields -->
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Save Changes
                                </button>
                            </form>
                        </div>

                        <!-- Security Edit Tab -->
                        <div class="tab-pane fade" id="security-edit">
                            <form id="password-form">
                                @csrf
                                <!-- Existing security form fields -->
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                    <div class="invalid-feedback" id="current_password-error"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <div class="invalid-feedback" id="password-error"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                    <div class="invalid-feedback" id="password_confirmation-error"></div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-shield-lock me-1"></i> Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Update Modal -->
<div class="modal fade" id="updatePhotoModal" tabindex="-1" aria-labelledby="updatePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePhotoModalLabel">Update Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="photo-form" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 text-center">
                        <div class="photo-preview-container mb-3">
                            <img id="photo-preview" src="{{ asset(auth()->user()->photo ?? 'images/default-avatar.png') }}" 
                                 class="img-fluid rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Choose a new photo</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <div class="invalid-feedback" id="photo-error"></div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload me-1"></i> Upload Photo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile form submission
    const profileForm = document.getElementById('profile-form');
    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        const formData = new FormData(profileForm);
        
        fetch('{{ route('profile.update') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showStatusMessage('success', data.message);
            } else {
                // Handle validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = document.getElementById(field);
                        const error = document.getElementById(field + '-error');
                        if (input && error) {
                            input.classList.add('is-invalid');
                            error.textContent = data.errors[field][0];
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showStatusMessage('danger', 'An error occurred. Please try again.');
        });
    });
    
    // Password form submission
    const passwordForm = document.getElementById('password-form');
    passwordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        const formData = new FormData(passwordForm);
        
        fetch('{{ route('profile.update.password') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showStatusMessage('success', data.message);
                passwordForm.reset();
            } else {
                // Handle validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = document.getElementById(field);
                        const error = document.getElementById(field + '-error');
                        if (input && error) {
                            input.classList.add('is-invalid');
                            error.textContent = data.errors[field][0];
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showStatusMessage('danger', 'An error occurred. Please try again.');
        });
    });
    
    // Photo form submission
    const photoForm = document.getElementById('photo-form');
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    
    // Preview image before upload
    photoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    photoForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        const formData = new FormData(photoForm);
        
        fetch('{{ route('profile.update.photo') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update all profile photos with user-specific URL
                document.querySelectorAll('.profile-photo').forEach(img => {
                    img.src = data.photo;
                    img.alt = "{{ auth()->user()->name }}";
                });
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('updatePhotoModal'));
                modal.hide();
                
                showStatusMessage('success', data.message);
            } else {
                // Handle validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const input = document.getElementById(field);
                        const error = document.getElementById(field + '-error');
                        if (input && error) {
                            input.classList.add('is-invalid');
                            error.textContent = data.errors[field][0];
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showStatusMessage('danger', 'An error occurred. Please try again.');
        });
    });
    
    // Helper function to show status messages
    function showStatusMessage(type, message) {
        const statusMessage = document.getElementById('status-message');
        statusMessage.className = `alert alert-${type}`;
        statusMessage.textContent = message;
        statusMessage.classList.remove('d-none');
        
        // Scroll to message
        statusMessage.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            statusMessage.classList.add('d-none');
        }, 5000);
    }
});
</script>
@endpush
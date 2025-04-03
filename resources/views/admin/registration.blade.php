@extends('admin.app')

@section('admincontent')
<style>
    .card {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <!-- Faculty Registration Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Faculty Registration</div>

                <div class="card-body">
                    <form action="{{ route('admin.store') }}" method="POST" id="faculty-registration-form">
                        @csrf

                        <div class="mb-3">
                            <label for="faculty_id" class="form-label">Faculty ID</label>
                            <input type="text" class="form-control @error('faculty_id') is-invalid @enderror" id="faculty_id" name="faculty_id" required>
                            @error('faculty_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rfid_uid" class="form-label">RFID UID</label>
                            <input type="password" class="form-control" id="rfid_uid" name="rfid_uid" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" required>
                            @error('fname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="mname" name="mname">
                        </div>

                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" required>
                            @error('lname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="suffix" class="form-label">Suffix (e.g., Jr., Sr.)</label>
                            <input type="text" class="form-control" id="suffix" name="suffix">
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>
                        <button type="button" class="btn btn-warning" id="clear-btn">Clear</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Key Registration Form (Right side container) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Key Registration</div>

                <div class="card-body">
                    <form action="{{ route('admin.labkeys.store') }}" method="POST" id="key-registration-form">
                        @csrf

                        <div class="mb-3">
                            <label for="key_id" class="form-label">Key ID</label>
                            <input type="text" class="form-control @error('key_id') is-invalid @enderror" id="key_id" name="key_id" required>
                            @error('key_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="laboratory" class="form-label">Laboratory</label>
                            <input type="text" class="form-control @error('laboratory') is-invalid @enderror" id="laboratory" name="laboratory" required>
                            @error('laboratory')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Register Key</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Toast Messages -->
<div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="toast-container">
        @if(session('success'))
            <div class="toast align-items-center text-bg-dark border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Include the JavaScript file -->
<script src="{{ asset('js/nfc-auth.js') }}" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show toast messages automatically
        var toastElements = document.querySelectorAll('.toast');
        toastElements.forEach(function(toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });

        const rfidInput = document.getElementById('rfid_uid');

        // Clear the RFID UID input field on page load
        rfidInput.value = ''; 

        document.getElementById('clear-btn').addEventListener('click', function () {
            // Get all the input fields in the form
            const form = document.getElementById('faculty-registration-form');
            form.reset(); // This will reset all form fields, including RFID UID
            rfidInput.value = ''; // Explicitly clear the RFID UID field if it's not reset
        });
    });
</script>

@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Cabinet - Admin Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/keyLogo.jpg') }}">

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- FontAwesome CSS CDN for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loginResponsive.css') }}">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <!-- Toast Notifications (Moved to Bottom Right) -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
        <div id="toastSuccess" class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
            <!-- <div class="toast-header">
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div> -->
            <div class="toast-body bg-dark">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        </div>

        <div id="toastError" class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
            <!-- <div class="toast-header">
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div> -->
            <div class="toast-body bg-dark">
                <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
            </div>
        </div>
    </div>

    <div class="card" style="max-width: 400px; width: 100%;">
        <div class="card-header bg-dark text-start">
            <i class="fas fa-key me-2"></i>Key Cab
        </div>
        <div class="card-body">
            <h4 class="text-label">Admin Login</h4>
            <form action="{{ route('admin.authenticate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control {{ session('error') ? 'is-invalid' : '' }}" 
                    id="username" name="username" required 
                    placeholder="Enter admin username" 
                    value="{{ old('username') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control {{ session('error') ? 'is-invalid' : '' }}" 
                        id="password" name="password" required 
                        placeholder="Enter admin password">
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark w-100">Login</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Password toggle
        document.getElementById("togglePassword").addEventListener("click", function () {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
            eyeIcon.classList.toggle("fa-eye");
            eyeIcon.classList.toggle("fa-eye-slash");
        });

        // Show Bootstrap toast notifications for success and error messages
        document.addEventListener("DOMContentLoaded", function () {
            const toastSuccess = document.getElementById("toastSuccess");
            const toastError = document.getElementById("toastError");

            if (toastSuccess.querySelector(".toast-body").textContent.trim() !== "") {
                new bootstrap.Toast(toastSuccess).show();
            }

            if (toastError.querySelector(".toast-body").textContent.trim() !== "") {
                new bootstrap.Toast(toastError).show();
            }
        });
    </script>
</body>
</html>

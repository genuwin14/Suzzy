<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/loader/welcome.css') }}">
    <script>
        setTimeout(() => {
            document.querySelector(".welcome-container").style.opacity = "0"; // Fade out
            setTimeout(() => {
                window.location.href = "{{ route('login') }}"; // Redirect
            }, 1000); // Wait for fade-out transition
        }, 3000); // Wait 3 seconds before starting transition
    </script>
</head>
<body>

    <div class="welcome-container">
        <div class="logo-container">
            <img src="{{ asset('images/keyLogo.jpg') }}" alt="Logo">
        </div>
        <h1>Smart Laboratory Key Cabinet Logbook</h1>
        <p class="description">A secure and efficient system for managing key access in laboratory facilities.</p>
    </div>

</body>
</html>
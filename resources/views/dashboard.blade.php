<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary text-white py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4">Dashboard</h1>
            <nav>
                <a href="{{ route('update-adhar') }}" class="btn btn-light btn-sm">Update Aadhaar</a>
                <a href="{{ route('logout') }}" class="btn btn-danger btn-sm" >
                    Logout
                </a>
            </nav>
        </div>
    </header>

    <main class="container my-4">
        <div class="card">
            <div class="card-body">
                <h2 class="h5">Welcome, {{ $user->firstname ." ". $user->lastname }}!</h2>
                <p>This is your dashboard where you can manage your account and access features.</p>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

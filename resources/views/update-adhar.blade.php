<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
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
        @if ($errors->any())
            <div style="color: red;" class="text-center">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
	@if(session('success'))
		<div style="color: green;" class="text-center">{{ session('success') }}</div>
	@endif

	@if(session('error'))
		<div style="color: red;" class="text-center">{{ session('error') }}</div>
	@endif
	<div class="container mt-5">
        <h2 class="text-center">Update Aadhaar Card</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="/update-adhar" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="aadhar_card" class="form-label">Enter Aadhaar Card Number</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="aadhar_card" id="aadhar_card" value="{{ $adhar_card ?? "" }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script>
		$('#aadhar_card').mask('0000-0000-0000');
	</script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

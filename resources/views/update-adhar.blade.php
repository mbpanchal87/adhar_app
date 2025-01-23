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
    @include('partials.header')
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
    @include('partials.footer')
</body>
</html>

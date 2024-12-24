<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Medi Mind</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            color: #fff;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .container {
            margin-top: 20px;
        }
        .list-group-item {
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }
        .request-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            width: 100%;
        }
        .request-card .request-info {
            flex: 1;
            text-align: left;
            margin-bottom: 0;
        }
        .request-card .request-status {
            text-align: center;
            flex: 1;
            margin-bottom: 0;
        }
        .request-card .request-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 0;
        }
        .center-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Medi Mind</a>
            <div class="ms-auto">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="my-4">Dashboard</h1>
        <p class="mt-3">Welcome, <strong>{{ auth()->user()->name }}</strong>!</p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Doctors -->
        <div class="mt-4 form-container">
            <form action="{{ route('search.doctors') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Search doctors" required>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <!-- Search Results -->
        @if(isset($doctor))
            <h2 class="mt-4">Search Results</h2>
            <ul class="list-group mt-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <strong>{{ $doctor->name }}</strong>
                    <form action="{{ route('request.doctor', $doctor->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Request</button>
                    </form>
                </li>
            </ul>
        @endif

      <!-- Your Requests -->
<h2 class="mt-4">Your Requests</h2>
<div class="row">
    @forelse($requests as $request)
        <div class="col-md-12">
            <div class="request-card">
                <div class="request-info">
                    <h5>{{ $request->doctor->name }}</h5>
                    <p>{{ ucfirst($request->status) }}</p>
                </div>
                <div class="request-actions">
                    @if($request->status === 'pending')
                        <form action="{{ route('cancel.request', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this request?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        </form>
                    @elseif($request->status === 'accepted')
                        <form action="{{ route('delete.request', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this request? This will also delete associated medicine records.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12">
            <p>No requests found.</p>
        </div>
    @endforelse
</div>

       

        <!-- Add Medicine and View Medicine Buttons -->
        <div class="center-buttons">
            <a href="{{ route('add.medicine', ['patient_id' => auth()->id()]) }}" class="btn btn-primary">Add Medicine</a>
            <a href="{{ route('view.medicine', ['patient_id' => auth()->id()]) }}" class="btn btn-success">View Medicines</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

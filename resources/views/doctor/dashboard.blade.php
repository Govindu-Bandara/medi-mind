<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - Medi Mind</title>
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

        .request-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .request-card .request-info {
            text-align: center;
            margin-bottom: 15px;
        }

        .request-card .request-actions {
            display: flex;
            gap: 10px;
        }

        .request-card img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-bottom: 15px;
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
        <h1 class="my-4">Doctor Dashboard</h1>
        <p class="mt-3">Welcome, <strong>{{ auth()->user()->name }}</strong>!</p>

        <!-- Pending Requests -->
        <h2 class="mt-4">Pending Requests</h2>
        <div class="row">
            @forelse($requests as $request)
                <div class="col-md-4">
                    <div class="request-card">
                        <div class="request-info">
                            <h5>{{ $request->patient->name }}</h5>
                            <p>{{ ucfirst($request->status) }}</p>
                        </div>
                        <div class="request-actions">
                            <form action="{{ route('doctor.acceptRequest', $request->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Accept</button>
                            </form>
                            <form action="{{ route('doctor.deleteRequest', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this request?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>No pending requests found.</p>
            @endforelse
        </div>

        <!-- Accepted Patients -->
        <h2 class="mt-4">Accepted Patients</h2>
        <div class="row">
            @forelse($patients as $patient)
                <div class="col-md-4">
                    <div class="request-card">
                        <img src="{{ asset('images/userm.jpeg') }}" alt="User Image">
                        <div class="request-info">
                            <h5>{{ $patient->name }}</h5>
                        </div>
                        <div class="request-actions">
                            <a href="{{ route('view.medicine', ['patient_id' => $patient->id]) }}" class="btn btn-success btn-sm">View Medicines</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No accepted patients found.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

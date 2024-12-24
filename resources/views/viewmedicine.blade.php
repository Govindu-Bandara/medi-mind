<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Medicine - Medi Mind</title>
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
        .card {
            border-radius: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-warning {
            background-color: #ffc107;
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
        .medicine-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .medicine-card .medicine-info {
            text-align: center;
            margin-bottom: 15px;
        }
        .medicine-card .medicine-actions {
            display: flex;
            gap: 10px;
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

    <section class="text-center mt-5">
        <h1>View Your Medicines</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="container mt-4">
            <div class="row">
                @foreach ($medicines as $medicine)
                    <div class="col-md-4">
                        <div class="medicine-card">
                            <div class="medicine-info">
                                <h5 class="card-title">{{ $medicine->name }} ({{ $medicine->dosage }} tablets)</h5>
                                <ul class="list-unstyled">
                                    @foreach ($medicine->times as $time)
                                        <li>{{ \Carbon\Carbon::parse($time->time)->format('H:i') }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="medicine-actions">
                                <a href="{{ route('edit.medicine', $medicine->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('delete.medicine', $medicine->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this medicine?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add Medicine Button -->
        <div class="mt-4">
            <a href="{{ route('add.medicine', ['patient_id' => $patient->id]) }}" class="btn btn-primary">Add Medicine</a>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine - Medi Mind</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> <!-- Add flatpickr CSS -->
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
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-warning {
            background-color: #ffc107;
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
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> <!-- Add flatpickr JS -->
    <script>
        // Initialize flatpickr for time input fields to force 24-hour format
        window.onload = function() {
            flatpickr('input[type="time"]', {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // Force 24-hour format
            });
        };

        // Function to dynamically add new time input fields
        function addTimeField() {
            var container = document.getElementById("timesContainer");
            var input = document.createElement("input");
            input.type = "time";
            input.name = "times[]";
            input.classList.add("form-control", "mt-2");
            input.placeholder = "Select time";

            // Check if there's any existing time input that is empty
            if (container.querySelectorAll('input[type="time"]').length > 0) {
                // If there's any empty input, prevent adding a new one
                if (container.querySelector('input[type="time"]:invalid')) {
                    alert("Please fill all the time inputs before adding a new one.");
                    return;
                }
            }

            container.appendChild(input);

            // Reinitialize flatpickr on the new input
            flatpickr(input, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // Force 24-hour format
            });
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Medi Mind</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Add Medicine for {{ $patient->name }}</h2>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Medicine Add Form -->
        <div class="card p-4 shadow-sm mb-4 form-container">
            <form action="{{ route('store.medicine', ['patient_id' => $patient->id]) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Medicine Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="dosage" class="form-label">Dosage (e.g., 1.5 tablets)</label>
                    <input type="number" step="0.1" class="form-control" id="dosage" name="dosage" value="{{ old('dosage') }}" required>
                </div>

                <div class="mb-3" id="timesContainer">
                    <label for="time" class="form-label">Time(s)</label>
                    <!-- Time input for 24-hour format -->
                    <input type="time" class="form-control" name="times[]" placeholder="Select time" required>
                </div>

                <!-- Buttons to add more time input fields and submit the form -->
                <div class="form-buttons">
                    <button type="button" class="btn btn-secondary" onclick="addTimeField()">Add Another Time</button>
                    <button type="submit" class="btn btn-primary">Add Medicine</button>
                </div>
            </form>
        </div>

        <!-- List of Added Medicines -->
        <h3 class="mt-5">Added Medicines</h3>
        <div class="row">
            @forelse ($medicines as $medicine)
                <div class="col-md-4">
                    <div class="medicine-card">
                        <div class="medicine-info">
                            <strong>{{ $medicine->name }}</strong> - {{ $medicine->dosage }} tablets
                            <ul class="list-unstyled mb-0">
                                @foreach ($medicine->times as $time)
                                    <!-- Convert and display time in 24-hour format -->
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
            @empty
                <p>No medicines added yet.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
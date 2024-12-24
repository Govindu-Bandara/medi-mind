<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medicine - Medi Mind</title>
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
        .time-field-container {
            display: flex;
            align-items: center;
            gap: 10px;
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
            var div = document.createElement("div");
            div.classList.add("time-field-container");

            var input = document.createElement("input");
            input.type = "time";
            input.name = "times[]";
            input.classList.add("form-control");
            input.placeholder = "Select time";

            var button = document.createElement("button");
            button.type = "button";
            button.classList.add("btn-close");
            button.onclick = function() {
                container.removeChild(div);
            };

            div.appendChild(input);
            div.appendChild(button);
            container.appendChild(div);

            // Reinitialize flatpickr on the new input
            flatpickr(input, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // Force 24-hour format
            });
        }

        // Function to add close buttons to existing time fields
        function addCloseButtonsToExistingFields() {
            var container = document.getElementById("timesContainer");
            var existingFields = container.querySelectorAll('.time-field-container');
            existingFields.forEach(function(div) {
                var button = document.createElement("button");
                button.type = "button";
                button.classList.add("btn-close");
                button.onclick = function() {
                    container.removeChild(div);
                };
                div.appendChild(button);
            });
        }

        // Add close buttons to existing time fields on page load
        window.onload = function() {
            flatpickr('input[type="time"]', {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // Force 24-hour format
            });
            addCloseButtonsToExistingFields();
        };
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Medi Mind</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Edit Medicine</h2>

        <!-- Flash Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Medicine Edit Form -->
        <div class="card p-4 shadow-sm mb-4 form-container">
            <form action="{{ route('medicine.update', $medicine->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Medicine Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $medicine->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="dosage" class="form-label">Dosage</label>
                    <!-- Allow decimal input for dosage -->
                    <input type="number" name="dosage" id="dosage" class="form-control" step="0.01" value="{{ old('dosage', $medicine->dosage) }}" required>
                </div>

                <div class="mb-3" id="timesContainer">
                    <label for="times" class="form-label">Times</label>
                    <!-- Display existing times in HH:mm format -->
                    @foreach($medicine->times as $key => $time)
                        <div class="time-field-container">
                            <input type="time" name="times[]" class="form-control mb-2" value="{{ old('times.' . $key, \Carbon\Carbon::parse($time->time)->format('H:i')) }}" required>
                        </div>
                    @endforeach
                </div>

                <!-- Buttons to add more time input fields and submit the form -->
                <div class="form-buttons">
                    <button type="button" id="add-time" class="btn btn-secondary" onclick="addTimeField()">Add Time</button>
                    <button type="submit" class="btn btn-primary">Update Medicine</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-time').addEventListener('click', function() {
            var container = document.getElementById("timesContainer");
            var div = document.createElement("div");
            div.classList.add("time-field-container");

            var input = document.createElement("input");
            input.type = "time";
            input.name = "times[]";
            input.classList.add("form-control");
            input.placeholder = "Select time";

            var button = document.createElement("button");
            button.type = "button";
            button.classList.add("btn-close");
            button.onclick = function() {
                container.removeChild(div);
            };

            div.appendChild(input);
            div.appendChild(button);
            container.appendChild(div);

            // Reinitialize flatpickr on the new input
            flatpickr(input, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // Force 24-hour format
            });
        });

        // Add close buttons to existing time fields on page load
        window.onload = function() {
            flatpickr('input[type="time"]', {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i", // Force 24-hour format
            });
            addCloseButtonsToExistingFields();
        };

        function addCloseButtonsToExistingFields() {
            var container = document.getElementById("timesContainer");
            var existingFields = container.querySelectorAll('.time-field-container');
            existingFields.forEach(function(div) {
                var button = document.createElement("button");
                button.type = "button";
                button.classList.add("btn-close");
                button.onclick = function() {
                    container.removeChild(div);
                };
                div.appendChild(button);
            });
        }
    </script>
</body>

</html>
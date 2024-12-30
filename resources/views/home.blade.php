<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medi Mind</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff;
        }
        .center-content {
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .btn-custom {
            margin: 0 10px;
        }
        .modal-header {
            background-color: #007bff;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-light {
            border: none;
        }
        .password-indicator {
            margin-right: 10px;
            color: gray;
        }
        .password-indicator.valid {
            color: green;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">Medi Mind</a>
            <div class="ms-auto">
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                <button class="btn btn-light ms-2" data-bs-toggle="modal" data-bs-target="#signInModal">Sign In</button>
            </div>
        </div>
    </nav>

    <!-- Main Content Section -->
    <section class="center-content">
        <h1 class="display-4">Welcome to Medi Mind</h1>
        <p class="lead">Timely reminders for a healthier you</p>
        <div>
            <button class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
            <button class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#signInModal">Sign In</button>
        </div>
    </section>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label><br>
                            <input type="radio" id="patient" name="role" value="patient" 
                                   @if(old('role') === 'patient') checked @endif>
                            <label for="patient">Patient</label><br>
                            <input type="radio" id="doctor" name="role" value="doctor" 
                                   @if(old('role') === 'doctor') checked @endif>
                            <label for="doctor">Doctor</label>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="password-indicators mt-2">
                                <span class="password-indicator" id="minLength">8 characters</span>
                                <span class="password-indicator" id="lowercase">Lowercase</span>
                                <span class="password-indicator" id="uppercase">Uppercase</span>
                                <span class="password-indicator" id="number">Number</span>
                                <span class="password-indicator" id="specialChar">Special character</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="passwordMatchError" class="text-danger d-none">Passwords do not match</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign In Modal -->
    <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signInModalLabel">Sign In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const indicators = {
                minLength: document.getElementById('minLength'),
                lowercase: document.getElementById('lowercase'),
                uppercase: document.getElementById('uppercase'),
                number: document.getElementById('number'),
                specialChar: document.getElementById('specialChar')
            };
            const regexPatterns = {
                minLength: /.{8,}/,
                lowercase: /[a-z]/,
                uppercase: /[A-Z]/,
                number: /\d/,
                specialChar: /[@$!%*?&#]/
            };

            passwordInput.addEventListener('input', () => {
                for (const key in indicators) {
                    if (regexPatterns[key].test(passwordInput.value)) {
                        indicators[key].classList.add('valid');
                    } else {
                        indicators[key].classList.remove('valid');
                    }
                }
            });

            passwordConfirmationInput.addEventListener('input', () => {
                const passwordMatchError = document.getElementById('passwordMatchError');
                if (passwordInput.value !== passwordConfirmationInput.value) {
                    passwordMatchError.classList.remove('d-none');
                } else {
                    passwordMatchError.classList.add('d-none');
                }
            });

            const form = document.querySelector('#registerModal form');
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false || passwordInput.value !== passwordConfirmationInput.value) {
                    event.preventDefault();
                    event.stopPropagation();
                    if (!document.getElementById('passwordMatchError').classList.contains('d-none')) {
                        document.getElementById('passwordMatchError').classList.remove('d-none');
                    }
                }
                form.classList.add('was-validated');
            });
        });
    </script>
</body>
</html>

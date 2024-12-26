<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Auth\AuthDoctorController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\DoctorAuthController;

// Public route for the home page
Route::get('/', function () {
    return view('home');
});

// Routes for unauthenticated users
Route::middleware('guest')->group(function () {
    // Register and Login routes for modal-based validation
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

// Routes for authenticated users
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/doctor/dashboard', [DashboardController::class, 'doctorIndex'])->name('doctor.dashboard');
    
    // Medicine management routes
    Route::get('/add-medicine/{patient_id}', [MedicineController::class, 'create'])->name('add.medicine');
    Route::post('/add-medicine/{patient_id}', [MedicineController::class, 'store'])->name('store.medicine');
    Route::get('/view-medicine/{patient_id}', [MedicineController::class, 'index'])->name('view.medicine');
    Route::get('/edit-medicine/{id}', [MedicineController::class, 'edit'])->name('edit.medicine');
    Route::put('/update-medicine/{id}', [MedicineController::class, 'update'])->name('medicine.update');
    Route::delete('/delete-medicine/{id}', [MedicineController::class, 'destroy'])->name('delete.medicine');
    
    // Doctor request management routes
    Route::post('/doctor/accept-request/{id}', [DoctorController::class, 'acceptRequest'])->name('doctor.acceptRequest');
    Route::delete('/doctor/delete-request/{id}', [DoctorController::class, 'deleteRequest'])->name('doctor.deleteRequest');
    
    // Search and request doctors
    Route::get('/search/doctors', [DashboardController::class, 'searchDoctors'])->name('search.doctors');
    Route::post('/request-doctor/{id}', [DashboardController::class, 'requestDoctor'])->name('request.doctor');
    
    // Cancel and delete requests
    Route::delete('/requests/{id}/cancel', [DashboardController::class, 'cancelRequest'])->name('cancel.request');
    Route::delete('/requests/{id}/delete', [DashboardController::class, 'deleteRequest'])->name('delete.request');
});

// Auth routes for doctor registration
Route::post('/register-doctor', [DoctorAuthController::class, 'register'])->name('register.doctor');

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

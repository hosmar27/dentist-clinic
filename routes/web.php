<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DentistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Initial Routes
Route::get('/', function () {
    return redirect('/login');
});

// AQUI ESTÁ A CORREÇÃO: Adicionamos o ->name('login')
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::post('/profile', [ProfileController::class, 'update']);

    // Appointments CRUD Routes
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/appointments/new', [AppointmentController::class, 'create']);
    Route::post('/appointments/save', [AppointmentController::class, 'store']);
    Route::get('/appointments/edit/{id}', [AppointmentController::class, 'edit']);
    Route::post('/appointments/update/{id}', [AppointmentController::class, 'update']);
    Route::post('/appointments/delete/{id}', [AppointmentController::class, 'destroy']);

    // Patient CRUD Routes
    Route::get('/patients', [PatientController::class, 'index']);
    Route::get('/patient/appointments', [AppointmentController::class, 'patientAppointments']);
    Route::get('/patients/new', [PatientController::class, 'create']);
    Route::post('/patients/save', [PatientController::class, 'store']);
    Route::get('/patients/edit/{id}', [PatientController::class, 'edit']);
    Route::post('/patients/update/{id}', [PatientController::class, 'update']);

    // Dentist CRUD Routes (admin only)
    Route::get('/dentists', [DentistController::class, 'index']);
    Route::get('/dentist/appointments', [AppointmentController::class, 'dentistAppointments']);
    Route::get('/dentists/new', [DentistController::class, 'create']);
    Route::post('/dentists/save', [DentistController::class, 'store']);
    Route::get('/dentists/edit/{id}', [DentistController::class, 'edit']);
    Route::post('/dentists/update/{id}', [DentistController::class, 'update']);
});
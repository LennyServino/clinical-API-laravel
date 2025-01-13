<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientsController;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//--> api

//rutas para los pacientes
Route::get('/v1/patients', [PatientsController::class, 'index']);
Route::post('/v1/patients', [PatientsController::class, 'store']);

//Ruta con parametros
Route::get('/v1/patients/{patientId}', [PatientsController::class, 'patient_by_id']);

//Ruta de tipo PATCH
Route::patch('/v1/patients/{patientId}', [PatientsController::class, 'update']);

//RUTAS PARA LAS CITAS
Route::post('/v1/appointments', [AppointmentController::class, 'store']);
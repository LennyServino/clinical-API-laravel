<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PatientsController;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//--> api

//agrupando rutas protegidas
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/v1/patients', [PatientsController::class, 'index']);
    //Ruta con parametros
    Route::get('/v1/patients/{patientId}', [PatientsController::class, 'patient_by_id']);
    //Ruta de tipo PATCH
    Route::patch('/v1/patients/{patientId}', [PatientsController::class, 'update']);

    //ruta para cerrar sesion
    Route::post('/v1/logut', [AuthenticationController::class, 'logout']);
});

//rutas para los pacientes
Route::post('/v1/patients', [PatientsController::class, 'store']);

//RUTAS PARA LAS CITAS
Route::post('/v1/appointments', [AppointmentController::class, 'store']);
//ruta para el metodo de las fechas (parametros opcionales)
Route::get('/v1/appointments', [AppointmentController::class, 'get_appointments']);

//Ruta para el login
Route::post('/v1/login', [AuthenticationController::class, 'login']);

//podemos colocar un nombre a la ruta
Route::get('/token', function() {
    return response()->json(['message' => 'Necesitas un token '], 401);
})->name('login');
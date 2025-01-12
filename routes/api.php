<?php

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
Route::post('v1/patients', [PatientsController::class, 'store']);
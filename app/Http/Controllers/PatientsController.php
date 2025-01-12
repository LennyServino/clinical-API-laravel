<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientsController extends Controller
{
    //obteniendo todos los pacientes
    public function index() {
        $patients = Patient::all(); //[]

        if(count($patients) > 0) {
            return response()->json($patients, 200);
        }

        return response()->json([], 204);
    }

    //metodo para guardar un paciente
    public function store(Request $request) {
        //validando la entrada de datos del usuario
        $validator = Validator::make($request->all(), [
            //reglas de validacion'
            'name' => 'required|string|max:50',
            'date_born' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:Masculino,Femenino',
            'address' => 'required|string',
            //validamdo que el telefono y el email sean unicos
            'phone' => 'required|digits:8|unique:patients',
            'email' => 'nullable|email|unique:patients,email'
        ]);

        //validando si se rompe las reglas de validacion
        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        //nueva instancia del modelo Patient
        $patient = new Patient();
        $patient->name = $request->input('name');
        $patient->date_born = $request->input('date_born');
        $patient->gender = $request->input('gender');
        $patient->address = $request->input('address');
        $patient->phone = $request->input('phone');
        $patient->email = $request->input('email');
        $patient->save(); //insert into patients

        return response()->json(['message' => 'Successfull created'], 201);
    }
}

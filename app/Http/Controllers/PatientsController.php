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
            ], 400);
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

    //obtener un paciente por id
    public function patient_by_id($id) {
        //validando que el id sea un numero
        $validator = Validator::make(['patient_id' => $id], [
            //reglas de validacion'
            'patient_id' => 'required|numeric',
        ]);

        //validando si se rompe las reglas de validacion
        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        //select * from patients where id = ?
        //Patient::where('id', $id)->get(); //query builder + orm
        $patient = Patient::find($id); //si existe devuelve el objeto, si no null

        if($patient != null) {
            return response()->json($patient, 200);
        }
        return response()->json(['message' => 'Patient not found'], 404);
    }

    //metodo para actualizar un paciente
    public function update(Request $request, $id) {
        //validando la entrada de datos del usuario
        $validator = Validator::make($request->all(), [
            //reglas de validacion'
            'name' => 'required|string|max:50',
            'address' => 'required|string',
            'phone' => 'required|digits:8',
            'email' => 'nullable|email'
        ]);

        //validando si se rompe las reglas de validacion
        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        //nueva instancia del modelo Patient
        $patient = Patient::find($id);
        $patient->name = $request->input('name');
        $patient->address = $request->input('address');
        $patient->phone = $request->input('phone');
        $patient->email = $request->input('email');
        $patient->update(); //update patients set name = ?, address = ?, phone = ?, email = ? where id = ?

        return response()->json(['message' => 'Correctly updated'], 200);
    }
}

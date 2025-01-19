<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    //metodo para iniciar sesion
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        //validando si se rompe las reglas de validacion
        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        //validamos si el usuario existe en la bd
        //select * from users where email = ? and password = ?
        $user = User::where('email', $email)->where('password', $password)->first(); //first() trae los datos en formato tipo objeto {}
        //User::where(['email' => $email, 'password' => $password])->first();

        if($user){
            //generar un token
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                "user" => $email,
                "token" => $token
            ], 200);
        } else {
            return response()->json(['message' => 'You are not authorized'], 401);
        }
    }

    //metodo para cerrar sesion
    public function logout(Request $request){
        //eliminando el ultimo token del usuario
        $request->user()->currentAccessToken()->delete();

        //eliminar todos los token del usuario
        //$request->user()->tokens()->delete();

        return response()->json(['message' => 'Se ha cerrado la session'], 200);
    }
}

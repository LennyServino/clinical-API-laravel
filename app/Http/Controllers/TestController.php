<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //
    public function get_patients() {
        //select * from patients
        //select * from patients where id = 2

        //FORMA 1 (QUERY BUILDER)
        DB::table('patients')->select('*')->get();
        DB::table('patients')->select('*')->where('id', 2)->get();

        //FORMA 2 (ORM ELOQUENT)
        Patient::all(); //select * from patients
        Patient::find(2); //select * from patients where id = 2
        Patient::where('id', 2)->get();

        //FORMA 2 (COMBINAR QUERY BUILDER Y ORM ELOQUENT)
        //select name, date_born from patients where gender = 'Femenino'
        Patient::where('gender', 'Femenino')->select('name', 'date_born')->get();

        //between = whereBetween
    }
}

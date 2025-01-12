<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //el modelo hace uso de datos quemados
    use HasFactory;
    //especificar que este modelo pertenece a la tabla patients
    protected $table = 'patients';
}

<?php

namespace Tests\Feature;

use App\Models\Appointments;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    //Limpia la base de datos antes de ejecutar las pruebas
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     * mocks => objetos simulados
     * assertions => afirmaciones
     */
    
    //test para obtener todos los pacientes
    public function test_get_patients(){
        //crear datos quemados para la prueba
        //Patient::factory(3)->create();

        $response = $this->getJson('api/v1/patients');
        $response->assertStatus(200); //verificar si pasa el test
        //$response->assertJsonCount(14); //verificar si pasa el test con 3 pacientes
    }

    //test para confirmar la creacion de un paciente
    public function test_store() {
        //Patient::factory()->create();
        //creando un usuario
        $user = User::factory()->create();
        //creando un token
        $token = $user->createToken('test_token')->plainTextToken;

        $patient = [
            'name' => 'Lenny Servino',
            'date_born' => '1999-12-24',
            'gender' => 'Masculino',
            'address' => 'Calle 1, #2',
            'phone' => '12345678',
            'email' => 'lenny@example.com'
        ];

        $response = $this->withHeader('Authorization', "Bearer $token")->postJson('api/v1/patients', $patient);
        $response->assertStatus(201);
    }

    //testeando el endpoint de obtener un paciente por doctor
    public function test_patients_by_doctor() {
        //creando un doctor
        $user = User::factory()->create(['rol_id' => 1]);
        $patient = Patient::factory()->create();

        //creando una cita con datos quemados
        $appointment = new Appointments();
        $appointment->user_id = $user->id;
        $appointment->patient_id = $patient->id;
        $appointment->date_appointment = now();
        $appointment->time_appointment = '13:00';
        $appointment->reason = 'Consulta general';
        $appointment->status = 'Pendiente';
        $appointment->save();

        //se asegura que haya un usuario autenticado
        $response = $this->actingAs($user)->getJson('api/v1/patients-doctor');
        $response->assertOk();
    }
}

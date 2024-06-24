<?php

namespace Database\Seeders;

use App\Models\Appointments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtén todas las citas existentes para evitar duplicados
        $existingAppointments = Appointments::all();

        // Intenta crear 20 nuevas citas
        for ($i = 0; $i < 30; $i++) {
            // Crea una nueva cita
            $newAppointment = Appointments::factory()->make();

            // Verifica si la nueva cita ya existe en las citas existentes
            $duplicate = $existingAppointments->contains(function ($existing) use ($newAppointment) {
                return $existing->date == $newAppointment->date && $existing->hour_id == $newAppointment->hour_id;
            });

            // Si no es un duplicado, guárdala en la base de datos y agrega a las existentes
            if (!$duplicate) {
                $newAppointment->save();
                $existingAppointments->push($newAppointment);
            }
        }
    }
}

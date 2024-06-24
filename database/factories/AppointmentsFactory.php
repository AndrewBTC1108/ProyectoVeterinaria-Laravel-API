<?php

namespace Database\Factories;

use App\Models\Hours;
use App\Models\Pets;
use App\Models\User;
use App\Models\Appointments;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener un user_id de un usuario existente
        $user = User::inRandomOrder()->first();

        // Obtener una mascota asociada al usuario
        $pet = Pets::where('user_id', $user->id)->inRandomOrder()->first();

        // Obtener un hour_id de una hora existente
        $hour = Hours::inRandomOrder()->first();

        // Generar una fecha aleatoria a partir de la fecha actual
        $date = $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d');

        // Verificar si ya hay una cita para esta mascota, fecha y hora
        $existingAppointment = Appointments::where('pet_id', $pet->id)
            ->where('date', $date)
            ->where('hour_id', $hour->id)
            ->first();

        // Si no hay una cita existente, crea una nueva
        if (!$existingAppointment) {
            return [
                'pet_id' => $pet->id,
                'date' => $date,
                'hour_id' => $hour->id,
                'reason' => $this->faker->randomElement(['urgencia', 'consulta']),
                'user_id' => $user->id,
                'status' => $this->faker->randomElement([0, 1])
            ];
        }

        // Si ya hay una cita existente, intenta generar una nueva llamando recursivamente a la función definition
        return $this->definition();
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pets>
 */
class PetsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //Para crear las especies del pet
        $species = $this->faker->randomElement(['felino', 'canino', 'roedor', 'ave']);
        $breed = $this->faker->randomElement(['Buldog', 'Grandanes', 'Golden', 'Persa', 'Angora', 'Japones']);
        $color = $this->faker->randomElement(['Blanco', 'Gris', 'Crema', 'Blanco y Negro', 'Gris con Crema']);
        $sex = $this->faker->randomElement(['Macho', 'Hembra']);
        // Obtener un user_id de un usuario existente
        $user = User::inRandomOrder()->first();
        return [
            //
            'name' => $this->faker->name(),
            'birth_date' => $this->faker->dateTimeThisDecade(),
            'species' => $species,
            'breed' => $breed,
            'color' => $color,
            'sex' => $sex,
            'user_id' => $user->id //Se utiliza el método User::factory() para generar un User relacionado con la pet. Esto asume que se tiene un Factory para la generación de datos de users.
        ];
    }
}

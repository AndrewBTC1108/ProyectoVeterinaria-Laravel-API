<?php

namespace Database\Seeders;

use App\Models\Pets;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Llamamos el Factory de User para Crear usuarios
        $users = User::factory()->count(3000)->create();

        // Para cada usuario, crea 2 o 3 mascotas
        $users->each(function ($user) {
            Pets::factory()->count(rand(1, 2))->create(['user_id' => $user->id]);
        });
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategoriaSeeder;
use Database\Seeders\PetsSeeder;
use Database\Seeders\HoursSeeder;
use Database\Seeders\AppointmentsSeeder;
use Database\Seeders\AdminCategoriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HoursSeeder::class,
            AdminCategoriesSeeder::class,
            CategoriaSeeder::class,
            PetsSeeder::class,
            AppointmentsSeeder::class,
            DoctorCategoriesSeeder::class
        ]);
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $passwordC = 'password1@';
        return [
            'cedula' => $this->faker->numberBetween(1000000000, 9999999999), //AG
            'name' => fake()->name(),
            'last_name' => $this->faker->lastName(), //AG
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => $this->faker->numberBetween(1000000000, 9999999999), //AG
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make($passwordC),
            'remember_token' => Str::random(10),
            'admin' => 0, //AG
            'doctor' => 0 //AG
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

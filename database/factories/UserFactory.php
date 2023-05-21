<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nik_tmu' => $this->faker->randomNumber(9, true),
            'name_tmu' => $this->faker->name(),
            'role_tmu' => 'user',
            'username_tmu' => fake()->unique()->safeEmail(),
            'password_tmu' => 'user', // password
            'created_by_tmu' => $this->faker->randomDigit(1),
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

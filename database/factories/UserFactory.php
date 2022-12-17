<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$Y3ISCy8yLDWISY2h7OtlKOBenq2/.474jJHnqeC3mOxcEMpo5Pm7y', // 123456789Aa-
            'remember_token' => Str::random(10),
            'address' => fake()->address(),
            'cover_Img' => fake()->imageUrl($width = 640, $height = 480),
            'profile_Img' => fake()->imageUrl($width = 640, $height = 480),
            'gender' => fake()->randomElement($array = array('male', 'female')),
            'phone_number' => fake()->e164PhoneNumber(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

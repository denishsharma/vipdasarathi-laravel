<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower($firstName . $lastName . '@gmail.com'),
            'slug' => \Str::slug($firstName . ' ' . \Str::substr($lastName, 0, 1) . ' ' . \Str::random(6)),
            'organization_id' => Organization::all()->random()->id,
            'email_verified_at' => now(),
            'password' => \Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified() {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

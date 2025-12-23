<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => 'User',
            'status' => 'Active',
            'branch' => 'Other',
            'gender' => 'Male',
            'phone' => $this->faker->phoneNumber(),
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'town' => $this->faker->city(),
            'state' => 'NY',
            'zipcode' => $this->faker->postcode(),
            'profile_confirmed' => false,
            'id_confirmed' => false,
            'status_confirmed' => false,
            'image' => null,
        ];
    }
}

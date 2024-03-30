<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company' => fake()->company(),
            'card_owner' => fake()->name(),
            'occupation' => fake()->jobTitle(),
            'adresse' => fake()->streetAddress(),
            'bio' =>fake()->paragraph(),
            'phone_number' => fake()->phoneNumber(),
            'e_mail' => fake()->safeEmail(),
            'user_id' => User::factory()
        ];
    }
}

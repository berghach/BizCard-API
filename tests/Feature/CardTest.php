<?php

namespace Tests\Feature;

use App\Models\Card;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testGetCardList()
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/cards');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function testCreateCard()
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user);

        $cardData = [
            'company' => $this->faker->company,
            'card_owner' => $this->faker->name,
            'occupation' => $this->faker->jobTitle,
            'adresse' => $this->faker->address,
            'bio' => $this->faker->paragraph,
            'phone_number' => $this->faker->phoneNumber,
            'e_mail' => $this->faker->unique()->safeEmail,
            'links' => [
                ['name' => 'Link 1', 'url' => 'https://example.com/link1'],
                ['name' => 'Link 2', 'url' => 'https://example.com/link2'],
            ],
        ];

        $response = $this->postJson('/api/cards', $cardData);

        $response->assertStatus(201)
            ->assertJsonStructure(['data']);
    }

    public function testGetCard()
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user);
        $card = Card::where('user_id', $user->id)->inRandomOrder()->first();

        $response = $this->getJson('/api/cards/' . $card->id);

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function testUpdateCard()
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user);

        $card = Card::factory()->create();

        $updatedData = [
            'company' => $this->faker->company,
            'card_owner' => $this->faker->name,
            'occupation' => $this->faker->jobTitle,
            'adresse' => $this->faker->address,
            'bio' => $this->faker->paragraph,
            'phone_number' => $this->faker->phoneNumber,
            'e_mail' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->putJson('/api/cards/' . $card->id, $updatedData);

        $response->assertStatus(200);
    }

    public function testDeleteCard()
    {
        $user = User::inRandomOrder()->first();
        Sanctum::actingAs($user);
        $card = Card::where('user_id', $user->id)->inRandomOrder()->first();

        $response = $this->deleteJson('/api/cards/' . $card->id);

        $response->assertStatus(200);
    }
}

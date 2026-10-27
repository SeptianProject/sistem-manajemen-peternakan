<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_peternakan' => fake()->company(),
            'alamat' => fake()->address(),
            'no_telp' => fake()->numerify('08##########'),
            'status' => 'aktif',
        ];
    }

    public function withOwner(): static
    {
        return $this->afterCreating(function (Client $client): void {
            User::factory()
                ->owner()
                ->create(['client_id' => $client->id]);
        });
    }
}

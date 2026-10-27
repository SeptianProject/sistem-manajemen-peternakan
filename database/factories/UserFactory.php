<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
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
        return [
            'nama' => fake()->name(),
            'no_telp' => fake()->numerify('08##########'),
            'username' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'pemilik',
            'status' => 'aktif',
            'remember_token' => fake()->regexify('[A-Za-z0-9]{10}'),
        ];
    }

    public function owner(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role' => 'pemilik',
            'status' => 'aktif',
        ]);
    }

    public function superadmin(): static
    {
        return $this->state(fn (array $attributes): array => [
            'client_id' => null,
            'role' => 'admin',
            'status' => 'aktif',
        ]);
    }
}

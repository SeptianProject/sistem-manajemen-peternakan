<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->superadmin()
            ->create([
                'nama' => 'Superadmin',
                'username' => 'superadmin',
            ]);

        $client = Client::factory()->create([
            'nama_peternakan' => 'Peternakan Demo',
            'alamat' => 'Jl. Peternakan No. 1',
            'no_telp' => '081234567890',
        ]);

        User::factory()
            ->owner()
            ->create([
                'client_id' => $client->id,
                'nama' => 'Pemilik Demo',
                'username' => 'pemilikdemo',
                'no_telp' => '081234567890',
            ]);
    }
}

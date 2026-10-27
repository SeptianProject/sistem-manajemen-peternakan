<?php

namespace App\Modules\Auth\Actions;

use App\Models\Client;
use App\Models\User;

class RegisterUserAction
{
    /**
     * @param  array{nama: string, no_telp?: ?string, username: string, password: string}  $attributes
     */
    public function handle(array $attributes): User
    {
        $client = Client::create([
            'nama_peternakan' => $attributes['nama'],
            'alamat' => '-',
            'no_telp' => $attributes['no_telp'] ?? '-',
            'status' => 'aktif',
        ]);

        return User::create([
            'client_id' => $client->id,
            'nama' => $attributes['nama'],
            'no_telp' => $attributes['no_telp'] ?? null,
            'username' => $attributes['username'],
            'password' => $attributes['password'],
            'role' => 'pemilik',
            'status' => 'aktif',
        ]);
    }
}

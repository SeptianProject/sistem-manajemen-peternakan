<?php

namespace App\Modules\Auth\Actions;

use App\Models\User;

class RegisterUserAction
{
    /**
     * @param  array{nama: string, no_telp?: ?string, username: string, password: string}  $attributes
     */
    public function handle(array $attributes): User
    {
        return User::create([
            'nama' => $attributes['nama'],
            'no_telp' => $attributes['no_telp'] ?? null,
            'username' => $attributes['username'],
            'password' => $attributes['password'],
            'role' => 'pemilik',
            'status' => 'aktif',
        ]);
    }
}

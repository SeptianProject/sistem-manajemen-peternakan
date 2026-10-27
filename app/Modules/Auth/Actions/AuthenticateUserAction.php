<?php

namespace App\Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;

class AuthenticateUserAction
{
    /**
     * @param  array{username: string, password: string}  $credentials
     */
    public function handle(array $credentials): bool
    {
        return Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'status' => 'aktif',
        ]);
    }
}

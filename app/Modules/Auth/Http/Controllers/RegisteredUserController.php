<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Actions\RegisterUserAction;
use App\Modules\Auth\Http\Requests\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request, RegisterUserAction $registerUser): RedirectResponse
    {
        $user = $registerUser->handle($request->validated());

        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}

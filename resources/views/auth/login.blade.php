<div>
@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <h2 class="auth-title">Masuk</h2>
    <p class="auth-subtitle">Selamat datang kembali! Silakan masuk untuk melanjutkan.</p>

    @if ($errors->any())
        <div class="auth-message auth-message--error">{{ $errors->first() }}</div>
    @endif

    @if (session('success'))
        <div class="auth-message auth-message--success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('login.attempt') }}" method="post" novalidate>
        @csrf
        <div class="auth-field">
            <label for="username" class="auth-label">Username</label>
            <input type="text" id="username" name="username" class="form-control auth-control" value="{{ old('username') }}" />
        </div>
        <div class="auth-field">
            <label for="password" class="auth-label">Password</label>
            <input type="password" id="password" name="password" class="form-control auth-control" />
            <a href="#" class="forgot-password">Lupa Password?</a>
        </div>

        <button type="submit" class="btn-masuk btn-auth mt-2">Masuk</button>
    </form>

    <p class="auth-divider">Belum punya akun?</p>
    <p class="auth-footer"><a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a></p>
@endsection
</div>

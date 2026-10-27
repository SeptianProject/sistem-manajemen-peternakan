<div>
@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <h2 class="auth-title">Daftar Akun</h2>
    <p class="auth-subtitle">Buat akun untuk mengakses sistem peternakan.</p>

    @if ($errors->any())
        <div class="auth-message auth-message--error">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('register.store') }}" method="post" novalidate>
        @csrf
        <div class="auth-field">
            <label for="nama" class="auth-label">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control auth-control" maxlength="100" required value="{{ old('nama') }}" />
        </div>

        <div class="auth-field">
            <label for="no_telp" class="auth-label">Nomor Telepon</label>
            <input type="text" id="no_telp" name="no_telp" class="form-control auth-control" maxlength="20" value="{{ old('no_telp') }}" />
        </div>

        <div class="auth-field">
            <label for="username" class="auth-label">Username</label>
            <input type="text" id="username" name="username" class="form-control auth-control" minlength="4" required value="{{ old('username') }}" />
        </div>

        <div class="auth-field">
            <label class="auth-label">Role</label>
            <input type="text" class="form-control auth-control" value="Pemilik" readonly />
        </div>

        <div class="auth-grid auth-grid--2">
            @foreach ([['password', 'Kata Sandi'], ['password_confirmation', 'Konfirmasi Kata Sandi']] as [$id, $label])
                <div class="auth-field">
                    <label for="{{ $id }}" class="auth-label">{{ $label }}</label>
                    <div class="auth-password-field">
                        <input type="password" id="{{ $id }}" name="{{ $id }}" class="form-control auth-control" required />
                        <span class="auth-password-toggle" onclick="togglePassword('{{ $id }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                            </svg>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn-daftar btn-auth mt-3">Daftar</button>
    </form>

    <p class="auth-divider">Sudah punya akun?</p>
    <p class="auth-footer"><a href="{{ route('login') }}" class="auth-link">Masuk di sini</a></p>
@endsection

@push('scripts')
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.setAttribute('type', field.getAttribute('type') === 'password' ? 'text' : 'password');
        }
    </script>
@endpush
</div>

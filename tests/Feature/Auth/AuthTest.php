<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a visitor to register as an active owner', function (): void {
    $response = $this->post(route('register.store'), [
        'nama' => 'Pemilik Baru',
        'no_telp' => '081234567890',
        'username' => 'pemilikbaru',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response
        ->assertRedirect(route('dashboard'))
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('users', [
        'nama' => 'Pemilik Baru',
        'username' => 'pemilikbaru',
        'role' => 'pemilik',
        'status' => 'aktif',
    ]);

    expect(auth()->user()->username)->toBe('pemilikbaru');
});

it('rejects invalid registration data', function (): void {
    $response = $this->from(route('register'))->post(route('register.store'), [
        'nama' => '',
        'username' => 'ab',
        'password' => 'password',
        'password_confirmation' => 'different-password',
    ]);

    $response
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors(['nama', 'username', 'password']);

    $this->assertDatabaseCount('users', 0);
});

it('allows an active user to log in and redirects to the dashboard', function (): void {
    User::factory()->create([
        'username' => 'pemilik',
        'password' => 'password',
        'status' => 'aktif',
    ]);

    $response = $this->post(route('login.attempt'), [
        'username' => 'pemilik',
        'password' => 'password',
    ]);

    $response
        ->assertRedirect(route('dashboard'))
        ->assertSessionHasNoErrors();

    expect(auth()->user()->username)->toBe('pemilik');
});

it('does not allow an inactive user to log in', function (): void {
    User::factory()->create([
        'username' => 'nonaktif',
        'password' => 'password',
        'status' => 'nonaktif',
    ]);

    $response = $this->from(route('login'))->post(route('login.attempt'), [
        'username' => 'nonaktif',
        'password' => 'password',
    ]);

    $response
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('username');

    expect(auth()->guest())->toBeTrue();
});

it('logs out the authenticated user and invalidates the session', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('logout'));

    $response->assertRedirect(route('login'));
    expect(auth()->guest())->toBeTrue();
});

it('requires authentication to access the dashboard', function (): void {
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('renders the owner dashboard after authentication', function (): void {
    $owner = User::factory()->owner()->create([
        'nama' => 'Pemilik Demo',
    ]);

    $this->actingAs($owner)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Selamat datang, Pemilik Demo!')
        ->assertSee('Data Ternak')
        ->assertSee('Pemilik Peternakan');
});

it('renders the superadmin dashboard after authentication', function (): void {
    $admin = User::factory()->superadmin()->create([
        'nama' => 'Superadmin Demo',
    ]);

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Selamat datang, Superadmin Demo!')
        ->assertSee('Manajemen Pengguna')
        ->assertSee('Superadmin');
});

it('renders the staff dashboard after authentication', function (): void {
    $staff = User::factory()->create([
        'role' => 'petugas',
        'nama' => 'Petugas Demo',
    ]);

    $this->actingAs($staff)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Selamat datang, Petugas Demo!')
        ->assertSee('Input Data')
        ->assertSee('Petugas');
});

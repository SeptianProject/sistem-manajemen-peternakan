<?php

use App\Models\Client;
use App\Models\Kandang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows an admin to manage clients', function (): void {
    $admin = User::factory()->superadmin()->create();

    $this->actingAs($admin)
        ->post(route('admin.clients.store'), [
            'nama_peternakan' => 'Peternakan Maju',
            'alamat' => 'Jl. Desa',
            'no_telp' => '08123456789',
            'status' => 'aktif',
        ])
        ->assertRedirect(route('management.clients.index'));

    $this->assertDatabaseHas('clients', ['nama_peternakan' => 'Peternakan Maju']);
});

it('scopes owner data to the authenticated client', function (): void {
    $client = Client::factory()->create();
    $otherClient = Client::factory()->create();
    $owner = User::factory()->owner()->create(['client_id' => $client->id]);
    Kandang::create(['client_id' => $client->id, 'nama' => 'Kandang Saya', 'lokasi' => 'A', 'kapasitas' => 10, 'status' => 'aktif']);
    Kandang::create(['client_id' => $otherClient->id, 'nama' => 'Kandang Lain', 'lokasi' => 'B', 'kapasitas' => 10, 'status' => 'aktif']);

    $this->actingAs($owner)
        ->get(route('owner.kandang.index'))
        ->assertOk()
        ->assertSee('Kandang Saya')
        ->assertDontSee('Kandang Lain');
});

it('keeps reports read only', function (): void {
    $admin = User::factory()->superadmin()->create();

    $this->actingAs($admin)
        ->get(route('management.reports'))
        ->assertOk()
        ->assertSee('read-only');
});

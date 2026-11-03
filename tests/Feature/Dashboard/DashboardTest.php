<?php

use App\Models\Client;
use App\Models\JenisProduksi;
use App\Models\JenisTernak;
use App\Models\Kandang;
use App\Models\ProductionRecord;
use App\Models\Ternak;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows live dashboard metrics only for the authenticated owners farm', function (): void {
    $client = Client::factory()->create();
    $otherClient = Client::factory()->create();
    $owner = User::factory()->owner()->create(['client_id' => $client->id]);
    $localSpecies = JenisTernak::create(['nama' => 'Sapi Lokal']);
    $otherSpecies = JenisTernak::create(['nama' => 'Ternak Luar']);
    $localBarn = Kandang::create([
        'client_id' => $client->id,
        'nama' => 'Kandang Utama',
        'lokasi' => 'Area A',
        'kapasitas' => 5,
        'status' => 'aktif',
    ]);
    $otherBarn = Kandang::create([
        'client_id' => $otherClient->id,
        'nama' => 'Kandang Eksternal',
        'lokasi' => 'Area B',
        'kapasitas' => 100,
        'status' => 'aktif',
    ]);
    $localAnimal = Ternak::create([
        'client_id' => $client->id,
        'kode' => 'TRN-LOCAL',
        'jenis_ternak_id' => $localSpecies->id,
        'kandang_id' => $localBarn->id,
        'jenis_kelamin' => 'betina',
        'tgl_lahir' => today()->subYear()->toDateString(),
        'status' => 'aktif',
    ]);
    $otherAnimal = Ternak::create([
        'client_id' => $otherClient->id,
        'kode' => 'TRN-OTHER',
        'jenis_ternak_id' => $otherSpecies->id,
        'kandang_id' => $otherBarn->id,
        'jenis_kelamin' => 'betina',
        'tgl_lahir' => today()->subYear()->toDateString(),
        'status' => 'aktif',
    ]);
    $milkProduction = JenisProduksi::create(['nama' => 'Susu', 'satuan' => 'L']);
    ProductionRecord::create([
        'client_id' => $client->id,
        'ternak_id' => $localAnimal->id,
        'jenis_produksi_id' => $milkProduction->id,
        'kandang_id' => $localBarn->id,
        'tgl_produksi' => today()->toDateString(),
        'jumlah' => 125,
    ]);
    ProductionRecord::create([
        'client_id' => $otherClient->id,
        'ternak_id' => $otherAnimal->id,
        'jenis_produksi_id' => $milkProduction->id,
        'kandang_id' => $otherBarn->id,
        'tgl_produksi' => today()->toDateString(),
        'jumlah' => 500,
    ]);

    $this->actingAs($owner)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Ternak Aktif')
        ->assertSee('1 / 5 slot')
        ->assertSee('125 L')
        ->assertSee('Sapi Lokal')
        ->assertSee('conic-gradient(#96ca50 0% 100%)', false)
        ->assertDontSee('Ternak Luar')
        ->assertDontSee('500 L');
});

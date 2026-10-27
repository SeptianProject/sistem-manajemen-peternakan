<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an owner with a client through the client factory', function (): void {
    $client = Client::factory()->withOwner()->create();

    $owner = $client->users()->sole();

    expect($owner->role)->toBe('pemilik')
        ->and($owner->status)->toBe('aktif')
        ->and($owner->client_id)->toBe($client->id);
});

it('creates an active superadmin without a client', function (): void {
    $admin = User::factory()->superadmin()->create();

    expect($admin->role)->toBe('admin')
        ->and($admin->status)->toBe('aktif')
        ->and($admin->client_id)->toBeNull();
});

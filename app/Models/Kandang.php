<?php

namespace App\Models;

use Database\Factories\KandangFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['client_id', 'nama', 'lokasi', 'kapasitas', 'status'])]
class Kandang extends Model
{
    protected $table = 'kandang';

    /** @use HasFactory<KandangFactory> */
    use HasFactory;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function ternak(): HasMany
    {
        return $this->hasMany(Ternak::class);
    }

    public function productionRecords(): HasMany
    {
        return $this->hasMany(ProductionRecord::class);
    }
}

<?php

namespace App\Models;

use Database\Factories\JabatanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama'])]
class Jabatan extends Model
{
    protected $table = 'jabatan';

    /** @use HasFactory<JabatanFactory> */
    use HasFactory;

    public function petugas(): HasMany
    {
        return $this->hasMany(Petugas::class);
    }
}

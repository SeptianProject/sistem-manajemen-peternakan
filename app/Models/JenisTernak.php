<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'suhu_min', 'suhu_max'])]
class JenisTernak extends Model
{
    protected $table = 'jenis_ternak';

    public function ternak(): HasMany
    {
        return $this->hasMany(Ternak::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama'])]
class Tindakan extends Model
{
    protected $table = 'tindakan';

    public function healthRecords(): HasMany
    {
        return $this->hasMany(HealthRecord::class);
    }
}

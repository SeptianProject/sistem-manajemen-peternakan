<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['client_id', 'ternak_id', 'petugas_id', 'tindakan_id', 'tgl_pemeriksaan', 'berat_badan', 'suhu_badan', 'diagnosa'])]
class HealthRecord extends Model
{
    protected $table = 'kesehatan';

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function ternak(): BelongsTo
    {
        return $this->belongsTo(Ternak::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class);
    }

    public function tindakan(): BelongsTo
    {
        return $this->belongsTo(Tindakan::class);
    }
}

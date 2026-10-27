<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['client_id', 'ternak_id', 'jenis_produksi_id', 'kandang_id', 'tgl_produksi', 'jumlah'])]
class ProductionRecord extends Model
{
    protected $table = 'produksi';

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function ternak(): BelongsTo
    {
        return $this->belongsTo(Ternak::class);
    }

    public function jenisProduksi(): BelongsTo
    {
        return $this->belongsTo(JenisProduksi::class);
    }

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class);
    }
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('ternak_id');
            $table->unsignedBigInteger('jenis_produksi_id');
            $table->unsignedBigInteger('kandang_id');

            $table->date('tgl_produksi');
            $table->decimal('jumlah', 10, 2);

            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')->on('client');

            $table->foreign('ternak_id')
                ->references('id')->on('ternak');

            $table->foreign('jenis_produksi_id')
                ->references('id')->on('jenis_produksi');

            $table->foreign('kandang_id')
                ->references('id')->on('kandang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};

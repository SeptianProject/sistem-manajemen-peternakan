
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kesehatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('ternak_id');
            $table->unsignedBigInteger('petugas_id');
            $table->unsignedBigInteger('tindakan_id')->nullable();

            $table->date('tgl_pemeriksaan');
            $table->decimal('berat_badan', 7, 2);
            $table->decimal('suhu_badan', 4, 2);
            $table->text('diagnosa');

            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')->on('clients');

            $table->foreign('ternak_id')
                ->references('id')->on('ternak');

            $table->foreign('petugas_id')
                ->references('id')->on('petugas');

            $table->foreign('tindakan_id')
                ->references('id')->on('tindakan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kesehatan');
    }
};

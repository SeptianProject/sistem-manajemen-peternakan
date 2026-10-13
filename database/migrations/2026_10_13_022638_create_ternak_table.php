
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ternak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('kode', 30);
            $table->unsignedBigInteger('jenis_ternak_id');
            $table->unsignedBigInteger('kandang_id');

            $table->enum('jenis_kelamin', [
                'jantan', 'betina'
            ]);

            $table->date('tgl_lahir');

            $table->enum('status', [
                'aktif', 'terjual', 'mati'
            ])->default('aktif');

            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')->on('client');

            $table->foreign('jenis_ternak_id')
                ->references('id')->on('jenis_ternak');

            $table->foreign('kandang_id')
                ->references('id')->on('kandang');

            $table->unique(['client_id', 'kode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ternak');
    }
};

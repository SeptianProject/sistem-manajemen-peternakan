
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('nama', 100);
            $table->string('no_telp', 20)->nullable();
            $table->string('username', 30)->unique();
            $table->string('password', 255);

            $table->enum('role', [
                'admin', 'pemilik', 'petugas'
            ]);

            $table->enum('status', [
                'aktif', 'nonaktif'
            ])->default('aktif');

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('client');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('jabatan_id');
            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')->on('clients');

            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->foreign('jabatan_id')
                ->references('id')->on('jabatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};

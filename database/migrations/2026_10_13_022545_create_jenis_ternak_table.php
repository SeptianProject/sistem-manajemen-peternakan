
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_ternak', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->unique();
            $table->decimal('suhu_min', 4, 2)->nullable();
            $table->decimal('suhu_max', 4, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_ternak');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('amplops', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lomba_id')->constrained('lombas')->onDelete('cascade');
        $table->string('nama_amplop'); // Contoh: Amplop 1
        $table->boolean('is_terpakai')->default(false); // Penanda amplop sudah dipilih/belum
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amplops');
    }
};

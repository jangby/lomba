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
    Schema::create('histori_skors', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lomba_id')->constrained('lombas')->onDelete('cascade');
        $table->foreignId('tim_id')->constrained('tims')->onDelete('cascade');
        $table->integer('perubahan_skor'); // Contoh: 100, atau -50
        $table->string('keterangan'); // Contoh: "Benar sesi rebutan", "Custom nilai lemparan"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_skors');
    }
};

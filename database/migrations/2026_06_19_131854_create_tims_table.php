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
    Schema::create('tims', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lomba_id')->constrained('lombas')->onDelete('cascade');
        $table->string('nama_tim'); // Contoh: Tim A
        $table->string('ketua');
        $table->string('anggota')->nullable(); // Nama anggota lainnya
        $table->integer('skor')->default(0); // Skor awal 0
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tims');
    }
};

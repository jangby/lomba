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
    Schema::table('lombas', function (Blueprint $table) {
        // Status spesifik di dalam babak (contoh: pilih_amplop, jawab_normal, jawab_lemparan)
        $table->string('sesi_state')->default('pilih_amplop')->after('status');
        
        // Menyimpan data tim mana yang sedang dapat giliran amplop
        $table->foreignId('tim_aktif_id')->nullable()->constrained(table: 'tims')->nullOnDelete();
        
        // Menyimpan data amplop mana yang sedang dibuka
        $table->foreignId('amplop_aktif_id')->nullable()->constrained(table: 'amplops')->nullOnDelete();
        
        // Menyimpan data tim mana yang berhasil merebut soal (saat dilempar)
        $table->foreignId('tim_lemparan_id')->nullable()->constrained(table: 'tims')->nullOnDelete();
        
        // Menyimpan urutan nomor soal (1 sampai 10)
        $table->integer('nomor_soal')->default(0);
    });
}

public function down(): void
{
    Schema::table('lombas', function (Blueprint $table) {
        $table->dropForeign(['tim_aktif_id']);
        $table->dropForeign(['amplop_aktif_id']);
        $table->dropForeign(['tim_lemparan_id']);
        $table->dropColumn(['sesi_state', 'tim_aktif_id', 'amplop_aktif_id', 'tim_lemparan_id', 'nomor_soal']);
    });
}
};

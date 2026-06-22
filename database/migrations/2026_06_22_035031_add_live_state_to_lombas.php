<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            // Memori untuk Dakwah
            $table->string('dakwah_peserta')->nullable();
            $table->integer('dakwah_waktu')->default(0);
            $table->string('dakwah_status')->default('reset');
            $table->timestamp('dakwah_last_start')->nullable();

            // Memori untuk Mudzakarah
            $table->string('mudzakarah_peserta')->nullable();
            $table->integer('mudzakarah_waktu')->default(0);
            $table->string('mudzakarah_status')->default('reset');
            $table->timestamp('mudzakarah_last_start')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->dropColumn([
                'dakwah_peserta', 'dakwah_waktu', 'dakwah_status', 'dakwah_last_start',
                'mudzakarah_peserta', 'mudzakarah_waktu', 'mudzakarah_status', 'mudzakarah_last_start'
            ]);
        });
    }
};
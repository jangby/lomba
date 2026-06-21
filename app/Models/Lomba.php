<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal kecuali ID
    protected $guarded = ['id'];

    // Relasi: Satu Lomba punya banyak Tim
    public function tims()
    {
        return $this->hasMany(Tim::class);
    }

    // Relasi: Satu Lomba punya banyak Amplop
    public function amplops()
    {
        return $this->hasMany(Amplop::class);
    }

    // Relasi: Satu Lomba punya banyak Histori Skor
    public function historiSkors()
    {
        return $this->hasMany(HistoriSkor::class);
    }

    // Relasi untuk mengambil data Tim yang sedang dapat giliran (Sesi Amplop)
    public function timAktif()
    {
        return $this->belongsTo(Tim::class, 'tim_aktif_id');
    }

    // Relasi untuk mengambil data Amplop yang sedang dibuka
    public function amplopAktif()
    {
        return $this->belongsTo(Amplop::class, 'amplop_aktif_id');
    }

    // Relasi untuk mengambil data Tim yang merebut soal lemparan
    public function timLemparan()
    {
        return $this->belongsTo(Tim::class, 'tim_lemparan_id');
    }
}
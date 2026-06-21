<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Tim ini milik Lomba apa?
    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    // Relasi: Satu Tim punya banyak Histori Skor
    public function historiSkors()
    {
        return $this->hasMany(HistoriSkor::class);
    }
}
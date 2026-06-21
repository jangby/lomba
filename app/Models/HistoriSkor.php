<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriSkor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Histori ini milik Tim siapa?
    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

    // Relasi: Histori ini terjadi di Lomba apa?
    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
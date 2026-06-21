<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amplop extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Amplop ini milik Lomba apa?
    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;
    public function lapangan()
    {
    return $this->belongsTo(Lapangan::class);
    }
}

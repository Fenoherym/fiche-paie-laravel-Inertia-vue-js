<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'mois'  => 'date:Y-m',
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}

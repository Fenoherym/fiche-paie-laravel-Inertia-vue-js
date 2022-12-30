<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }
}

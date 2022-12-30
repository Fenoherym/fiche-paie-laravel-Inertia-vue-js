<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function congestatut()
    {
        return $this->belongsTo(Congestatut::class);
    }
}

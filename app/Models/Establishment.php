<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "societe_id"
    ];
    public function workplaces()
    {
        return $this->hasMany(Workplace::class);
    }

    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }
}

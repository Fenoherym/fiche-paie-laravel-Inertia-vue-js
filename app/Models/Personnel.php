<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        "birthday" => 'date:d-m-Y'
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    public function statut()
    {
        return $this->belongsTo(Statut::class);
    }

    public function workplace()
    {
        return $this->belongsTo(Workplace::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }
}

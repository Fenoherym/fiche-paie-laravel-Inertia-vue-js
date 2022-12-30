<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        "content",
        "user_id",
        "conge_id"
    ];
    public function conge()
    {
        return $this->belongsTo(Conge::class);
    }
}

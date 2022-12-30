<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrique extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bulletins()
    {
        return $this->belongsToMany(Bulletin::class, 'bulletin_rubrique');
    }
}

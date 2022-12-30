<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }

    public function payement()
    {
        return $this->belongsTo(Payement::class);
    }

    public function rubriques()
    {
        return $this->belongsToMany(Rubrique::class, 'bulletin_rubrique');
    }

    public function indemnities()
    {
        return $this->hasMany(Indemnity::class);
    }
}

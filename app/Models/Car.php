<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        "reference",
        "user_id",
        "latitude",
        "longitude",
        "speed",
        "matricule"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function traject()
    {
        return $this->belongsTo(Traject::class);
    }

}

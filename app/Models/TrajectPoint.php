<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrajectPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        "latitude",
        "longitude",
    ];

    // hide created_at and updated_at from response
    protected $hidden = [
        "created_at",
        "updated_at",
        "traject_id"
    ];
}

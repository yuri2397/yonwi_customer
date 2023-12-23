<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

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

    protected $appends = ['link'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function traject()
    {
        return $this->belongsTo(Traject::class);
    }
    
    public function getLinkAttribute($key){
        return URL::to("/api/cars/{$this->reference}");
    }

}

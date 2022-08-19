<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['google_id', 'email', 'name', 'image_url'];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'visitor_id', 'id');
    }
}

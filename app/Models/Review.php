<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['visitor_id', 'bumdes_id', 'rating', 'description'];
    protected $hidden = ['visitor_id', 'bumdes_id'];
    
    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id', 'id');
    }

    public function bumdes()
    {
        return $this->belongsTo(Bumdes::class, 'bumdes_id', 'id');
    }
}

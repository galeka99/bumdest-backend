<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    use HasFactory;

    protected $fillable = ['token', 'user_id', 'expired_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'project_id', 'user_id', 'investment_status_id'];
    protected $hidden = ['project_id', 'user_id', 'investment_status_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(InvestmentStatus::class, 'investment_status_id', 'id');
    }
}

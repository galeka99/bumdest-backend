<?php

namespace App\Models;

use App\Http\Helper;{}
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'invest_target', 'offer_start_date', 'offer_end_date', 'proposal_path', 'bumdes_id', 'status_id'];
    protected $hidden = ['proposal_path', 'bumdes_id', 'status_id'];
    protected $with = ['images', 'bumdes', 'status'];
    protected $appends = ['current_invest', 'proposal', 'vote_average', 'vote_count'];

    public function getCurrentInvestAttribute()
    {
        $current = $this->hasMany(Investment::class, 'project_id', 'id')->where('investment_status_id', 2)->sum('amount');
        return $current;
    }

    public function getProposalAttribute()
    {
        if ($this->proposal_path) {
            return Helper::fileUrl($this->proposal_path);
        } else {
            return null;
        }
    }

    public function getVoteAverageAttribute()
    {
        $avg = $this->hasMany(Rating::class, 'project_id', 'id')->avg('value');
        return floatval($avg);
    }

    public function getVoteCountAttribute()
    {
        return $this->hasMany(Rating::class, 'project_id', 'id')->count();
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class, 'project_id', 'id');
    }

    public function bumdes()
    {
        return $this->belongsTo(Bumdes::class, 'bumdes_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'status_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'project_id', 'id');
    }
}

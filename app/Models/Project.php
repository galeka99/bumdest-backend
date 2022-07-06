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
    protected $appends = ['current_invest', 'proposal', 'rating', 'rating_count'];

    public function getCurrentInvestAttribute()
    {
        $investments = $this->hasMany(Investment::class, 'project_id', 'id')->getResults();
        $total = 0;
        foreach ($investments as $investment) {
            $total += $investment->amount;
        }

        return $total;
    }

    public function getProposalAttribute()
    {
        if ($this->proposal_path) {
            return Helper::fileUrl($this->proposal_path);
        } else {
            return null;
        }
    }

    public function getRatingAttribute()
    {
        $rating_total = $this->hasMany(Rating::class, 'project_id', 'id')->selectRaw('SUM(value) AS total')->get('total')[0]['total'];
        $rating_count = $this->hasMany(Rating::class, 'project_id', 'id')->count();
        return $rating_total / $rating_count;
    }

    public function getRatingCountAttribute()
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

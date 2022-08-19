<?php

namespace App\Models;

use App\Http\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'month', 'year', 'profit', 'report_file'];
    protected $hidden = ['project_id', 'report_file'];
    protected $appends = ['report_url'];

    public function getReportUrlAttribute()
    {
        if ($this->report_file == null) return null;
        return Helper::fileUrl($this->report_file);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(MonthlyReportDetail::class, 'monthly_report_id', 'id');
    }
}

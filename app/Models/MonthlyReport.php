<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'month', 'year', 'profit', 'report_file'];
    protected $hidden = ['project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(MonthlyReportDetail::class, 'monthly_report_id', 'id');
    }
}

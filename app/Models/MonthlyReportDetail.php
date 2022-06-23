<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReportDetail extends Model
{
    use HasFactory;

    protected $fillable = ['monthly_report_id', 'user_id', 'percentage', 'amount'];
    protected $hidden = ['monthly_report_id'];

    public function parent()
    {
        return $this->belongsTo(MonthlyReport::class, 'monthly_report_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

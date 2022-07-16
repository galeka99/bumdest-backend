<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'phone', 'balance', 'address', 'postal_code', 'district_id', 'gender_id', 'role_id', 'user_status_id', 'bumdes_id', 'verified'];
    protected $hidden = ['password', 'district_id', 'gender_id', 'role_id', 'user_status_id', 'bumdes_id', 'remember_token'];
    protected $appends = ['gender', 'location', 'total_invest', 'total_income'];
    
    public function getGenderAttribute()
    {
        $gender = $this->belongsTo(Gender::class, 'gender_id', 'id')->getResults();
        return $gender->label;
    }

    public function getLocationAttribute()
    {
        $district = $this->belongsTo(District::class, 'district_id', 'id')->getResults();
        return [
            'district_id' => $district->id,
            'district_name' => $district->name,
            'city_id' => $district->city->id,
            'city_name' => $district->city->name,
            'province_id' => $district->city->province->id,
            'province_name' => $district->city->province->name,
        ];
    }

    public function getTotalInvestAttribute() {
        $investments = Investment::where('user_id', $this->id)->where('investment_status_id', 2)->sum('amount');
        return intval($investments);
    }

    public function getTotalIncomeAttribute() {
        $incomes = MonthlyReportDetail::where('user_id', $this->id)->sum('amount');
        return intval($incomes);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function user_status()
    {
        return $this->belongsTo(UserStatus::class, 'user_status_id', 'id');
    }

    public function bumdes()
    {
        return $this->belongsTo(Bumdes::class, 'bumdes_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id', 'id');
    }
}

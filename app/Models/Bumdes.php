<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bumdes extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'balance', 'district_id', 'address', 'postal_code', 'description'];
    protected $hidden = ['district_id'];
    protected $appends = ['location'];

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

    public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'bumdes_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}

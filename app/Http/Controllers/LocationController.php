<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function provinces()
    {
        $provinces = Province::all();
        return Helper::sendJson(null, $provinces);
    }

    public function cities(int $id)
    {
        $cities = City::where('province_id', $id)->get();
        return Helper::sendJson(null, $cities);
    }

    public function districts(int $id)
    {
        $districts = District::where('city_id', $id)->get();
        return Helper::sendJson(null, $districts);
    }
}

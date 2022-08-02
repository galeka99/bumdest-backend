<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Bumdes;
use App\Models\Investment;
use App\Models\Project;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BumdesApiController extends Controller
{
    public function list(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $bumdes = Bumdes::inRandomOrder()->paginate($limit);
        $hidden_fields = ['phone', 'postal_code', 'description'];

        return Helper::sendJson(null, Helper::paginate($bumdes, $hidden_fields));
    }

    public function detail(int $id)
    {
        $bumdes = Bumdes::find($id);
        if (!$bumdes) return Helper::sendJson('BUMDES_NOT_FOUND', null, 404);

        return Helper::sendJson(null, $bumdes);
    }

    public function reviews(Request $request, int $id)
    {
        $bumdes = Bumdes::find($id);
        if (!$bumdes) return Helper::sendJson('BUMDES_NOT_FOUND', null, 404);

        $limit = intval($request->input('limit', '25'));
        $reviews = Review::where('bumdes_id', $bumdes->id)
            ->with(['visitor:id,name,image_url'])
            ->paginate($limit);

        return Helper::sendJson(null, Helper::paginate($reviews));
    }

    public function product_list(Request $request, int $id)
    {
        $limit = intval($request->input('limit', '25'));
        $projects = Project::where('bumdes_id', $id)
            ->whereDate('offer_start_date', '<=', Carbon::now())
            ->whereDate('offer_end_date', '>=', Carbon::now())
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        $hidden_fields = ['proposal', 'images'];

        return Helper::sendJson(null, Helper::paginate($projects, $hidden_fields));
    }

    public function top_ten_investors(Request $request, int $id)
    {
        $investors = Investment::whereHas('project', function ($query) use ($id) {
            return $query->where('bumdes_id', $id);
        })
            ->where('investment_status_id', 2)
            ->selectRaw('SUM(amount) as total, user_id')
            ->with(['user:id,name,gender_id,district_id'])
            ->groupBy('user_id')
            ->orderBy('total')
            ->take(10)
            ->get()
            ->map(function ($el) {
                return [
                    'user_id' => $el->user->id,
                    'user_name' => $el->user->name,
                    'user_province' => $el->user->location['province_name'],
                    'user_city' => $el->user->location['city_name'],
                    'user_district' => $el->user->location['district_name'],
                    'total_invest' => intval($el->total),
                ];
            });
        
        return Helper::sendJson(null, $investors);
    }
}

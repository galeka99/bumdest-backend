<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Bumdes;
use App\Models\Project;
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
}

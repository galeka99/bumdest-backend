<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentApiController extends Controller
{
    public function list(Request $request)
    {
        $limit = intval($request->post('limit', '25'));
        $investments = Investment::where('user_id', $request->user->id)
            ->with(['project', 'project.status', 'project.bumdes:id,name,district_id', 'status'])
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);

        return Helper::sendJson(null, Helper::paginate($investments));
    }

    public function detail(Request $request, int $id)
    {
        $investment = Investment::where('id', $id)
            ->where('user_id', $request->user->id)
            ->with(['project', 'project.status', 'project.bumdes:id,name,district_id', 'status'])
            ->first();

        if (!$investment) return Helper::sendJson('INVESTMENT_NOT_FOUND', null, 404);

        return Helper::sendJson(null, $investment);
    }
}

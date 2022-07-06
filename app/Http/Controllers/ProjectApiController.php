<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Investment;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectApiController extends Controller
{
    public function newest(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $projects = Project::with(['images', 'bumdes:id,name,district_id', 'status'])
            ->whereDate('offer_start_date', '<=', Carbon::now())
            ->whereDate('offer_end_date', '>=', Carbon::now())
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        $hidden_fields = ['proposal', 'images'];
        
        return Helper::sendJson(null, Helper::paginate($projects, $hidden_fields));
    }

    public function detail(int $id)
    {
        $project = Project::where('id', $id)
            ->with(['images', 'bumdes', 'status'])
            ->first();
        if (!$project) return Helper::sendJson('PRODUCT_NOT_FOUND', null, 404);

        return Helper::sendJson(null, $project);
    }

    public function invest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) return Helper::sendJson('INVALID_REQUEST', $validator->errors(), 400);

        $amount = intval($request->post('amount', '0'));
        $project = Project::where('id', $request->post('product_id'))
            ->with(['images', 'bumdes', 'status'])
            ->first();
        if (!$project) return Helper::sendJson('PRODUCT_NOT_FOUND', null, 404);

        if ($request->user->balance < $amount) return Helper::sendJson('INSUFFICIENT_BALANCE', null, 403);

        $user = User::find($request->user->id);
        $user->balance -= $amount;
        $user->save();

        Investment::create([
            'amount' => $amount,
            'project_id' => $project->id,
            'user_id' => $user->id,
            'investment_status_id' => 1,
        ]);

        return Helper::sendJson(null, null);
    }
}

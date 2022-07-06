<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Project;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingApiController extends Controller
{
    public function check(Request $request, int $id)
    {
        $rating = Rating::where('id', $id)->where('user_id', $request->user->id)->first();
        if (!$rating) {
            return Helper::sendJson(null, null);
        } else {
            return Helper::sendJson(null, $rating->value);
        }
    }

    public function rate(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric|between:1,5',
        ]);
        if ($validator->fails()) return Helper::sendJson('INVALID_REQUEST', $validator->errors(), 400);

        $project = Project::where('id', $id)->first();
        if (!$project) return Helper::sendJson('PRODUCT_NOT_FOUND', null, 404);
        $rating = Rating::where('id', $id)->where('user_id', $request->user->id)->first();
        if ($rating) return Helper::sendJson('ALREADY_RATED', null, 403);

        $rating = Rating::create([
            'value' => intval($request->post('value', '5')),
            'user_id' => $request->user->id,
            'project_id' => $project->id,
        ]);

        return Helper::sendJson(null, $rating->value);
    }
}

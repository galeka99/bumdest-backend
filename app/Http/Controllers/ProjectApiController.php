<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Investment;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Config;

class ProjectApiController extends Controller
{
    public function random(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $projects = Project::with(['bumdes:id,name,district_id', 'status'])
            ->whereDate('offer_start_date', '<=', Carbon::now())
            ->whereDate('offer_end_date', '>=', Carbon::now())
            ->inRandomOrder()
            ->paginate($limit);
        $hidden_fields = ['proposal', 'images'];

        return Helper::sendJson(null, Helper::paginate($projects, $hidden_fields));
    }

    public function newest(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $projects = Project::with(['bumdes:id,name,district_id', 'status'])
            ->whereDate('offer_start_date', '<=', Carbon::now())
            ->whereDate('offer_end_date', '>=', Carbon::now())
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        $hidden_fields = ['proposal', 'images'];
        
        return Helper::sendJson(null, Helper::paginate($projects, $hidden_fields));
    }

    public function almost_end(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $projects = Project::with(['bumdes:id,name,district_id', 'status'])
            ->whereDate('offer_start_date', '<=', Carbon::now())
            ->whereDate('offer_end_date', '>=', Carbon::now())
            ->orderBy('offer_end_date', 'DESC')
            ->paginate($limit);
        $hidden_fields = ['proposal', 'images'];
        
        return Helper::sendJson(null, Helper::paginate($projects, $hidden_fields));
    }

    public function search(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $q = $request->get('q', '');
        $projects = Project::with(['bumdes:id,name,district_id', 'status'])
            ->whereDate('offer_start_date', '<=', Carbon::now())
            ->whereDate('offer_end_date', '>=', Carbon::now())
            ->where('title', 'LIKE', "%$q%")
            ->orWhere('description', 'LIKE', "%$q%")
            ->orderBy('offer_end_date', 'DESC')
            ->paginate($limit);
        $hidden_fields = ['proposal', 'images'];
        
        return Helper::sendJson(null, Helper::paginate($projects, $hidden_fields));
    }

    public function related_products(int $id)
    {
        $project = Project::where('id', $id)
            ->with(['images', 'bumdes', 'status'])
            ->first();
        if (!$project) return Helper::sendJson('PRODUCT_NOT_FOUND', null, 404);

        $projects = [];

        try {
            $url = config('app.ai_url').'/related_project_rec/';

            // GET DATA FROM RECOMMENDER SYSTEM
            $res = Http::asForm()
                ->post($url, [
                    'project_id' => $project->id,
                ]);

            $response = $res->body();
            if ($response == '0') {
                // USE RANDOM PRODUCTS
                $projects = Project::with(['bumdes:id,name,district_id', 'status'])
                ->whereDate('offer_start_date', '<=', Carbon::now())
                ->whereDate('offer_end_date', '>=', Carbon::now())
                ->inRandomOrder()
                ->take(10)
                ->get()
                ->map(function ($el) {
                    unset($el->proposal);
                    unset($el->images);
                    return $el;
                });
            } else {
                $project_list = explode("\n", $response);
                foreach ($project_list as $proj) {
                    $project = Project::find($proj);
                    if ($project) array_push($projects, $project);
                }
            }
        } catch (Exception $err) {
            // USE RANDOM PRODUCTS
            $projects = Project::with(['bumdes:id,name,district_id', 'status'])
                ->whereDate('offer_start_date', '<=', Carbon::now())
                ->whereDate('offer_end_date', '>=', Carbon::now())
                ->inRandomOrder()
                ->take(10)
                ->get()
                ->map(function ($el) {
                    unset($el->proposal);
                    unset($el->images);
                    return $el;
                });
            
            return response($err->getMessage());
        }

        return Helper::sendJson(null, $projects);
    }

    public function recommended_products(Request $request)
    {
        $user = User::find($request->user->id);
        if (!$user) return Helper::sendJson('USER_NOT_FOUND', null, 404);

        $projects = [];

        try {
            $url = config('app.ai_url').'/investor_rec/';

            // GET DATA FROM RECOMMENDER SYSTEM
            $res = Http::asForm()
                ->post($url, [
                    'user_id' => $user->id,
                ]);

            $response = $res->body();
            if ($response == '0') {
                // USE RANDOM PRODUCTS
                $projects = Project::with(['bumdes:id,name,district_id', 'status'])
                ->whereDate('offer_start_date', '<=', Carbon::now())
                ->whereDate('offer_end_date', '>=', Carbon::now())
                ->inRandomOrder()
                ->take(10)
                ->get()
                ->map(function ($el) {
                    unset($el->proposal);
                    unset($el->images);
                    return $el;
                });
            } else {
                $project_list = explode("\n", $response);
                foreach ($project_list as $proj) {
                    $project = Project::find($proj);
                    if ($project) array_push($projects, $project);
                }
            }
        } catch (Exception $err) {
            // USE RANDOM PRODUCTS
            $projects = Project::with(['bumdes:id,name,district_id', 'status'])
                ->whereDate('offer_start_date', '<=', Carbon::now())
                ->whereDate('offer_end_date', '>=', Carbon::now())
                ->inRandomOrder()
                ->take(10)
                ->get()
                ->map(function ($el) {
                    unset($el->proposal);
                    unset($el->images);
                    return $el;
                });
            
            return response($err->getMessage());
        }

        return Helper::sendJson(null, $projects);
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

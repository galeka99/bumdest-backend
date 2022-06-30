<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function list(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $investors = Investment::whereHas('project', function ($query) {
            return $query->where('bumdes_id', auth()->user()->bumdes->id);
        })
            ->where('investment_status_id', 2)
            ->selectRaw('SUM(amount) as total, user_id')
            ->groupBy('user_id')
            ->orderBy('total')
            ->paginate($limit);

        return view('dashboard.investors.index', compact('investors'));
    }

    public function detail(int $id)
    {
        $investor = User::where('id', $id)->where('role_id', 3)->first();
        if (!$investor) return redirect('/investors')->with('error', 'Investor not found');

        $investments = Investment::whereHas('project', function ($query) {
            return $query->where('bumdes_id', auth()->user()->bumdes->id);
        })
            ->where('user_id', $investor->id)
            ->where('investment_status_id', 2)
            ->selectRaw('SUM(amount) as total, user_id, project_id')
            ->groupBy('user_id')
            ->groupBy('project_id')
            ->get();

        return view('dashboard.investors.detail', compact('investor', 'investments'));
    }
}

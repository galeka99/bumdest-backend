<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Bumdes;
use App\Models\Investment;
use App\Models\User;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function list(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $investments = Investment::whereHas('project', function ($query) {
            return $query->where('bumdes_id', auth()->user()->bumdes->id);
        })
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        
        return view('dashboard.investments.index', compact('investments'));
    }

    public function accept(int $id)
    {
        $inv = Investment::where('id', $id)
            ->whereHas('project', function ($query) {
                return $query->where('bumdes_id', auth()->user()->bumdes->id);
            })
            ->first();

        if (!$inv) return redirect('/investments')->with('error', 'Investment not found');
        if ($inv->status->id !== 1) return redirect('/investments')->with('error', 'Invalid investment status');

        // ADD BALANCE TO BUMDES
        $bumdes = Bumdes::find(auth()->user()->bumdes->id);
        $bumdes->balance += $inv->amount;
        $bumdes->save();

        // UPDATE STATUS TO INVESTMENT
        $inv->investment_status_id = 2;
        $inv->save();

        return redirect('/investments')->with('success', 'Investment accepted');
    }

    public function reject(int $id)
    {
        $inv = Investment::where('id', $id)
            ->whereHas('project', function ($query) {
                return $query->where('bumdes_id', auth()->user()->bumdes->id);
            })
            ->first();

        if (!$inv) return redirect('/investments')->with('error', 'Investment not found');
        if ($inv->status->id !== 1) return redirect('/investments')->with('error', 'Invalid investment status');

        // REFUND BALANCE TO USER
        $user = User::find($inv->user->id);
        $user->balance += $inv->amount;
        $user->save();

        // UPDATE STATUS TO INVESTMENT
        $inv->investment_status_id = 3;
        $inv->save();

        return redirect('/investments')->with('success', 'Investment rejected');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use App\Models\Investment;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id === 1) {
            $bumdes_count = Bumdes::count();
            $investor_count = User::where('role_id', 3)->count();
            $project_count = Project::count();
            $invest_count = Investment::where('investment_status_id', 2)->count();

            $bumdes = Bumdes::orderBy('created_at', 'DESC')->take(10)->get();
            $users = User::whereBetween('role_id', [2, 3])->orderBy('created_at', 'DESC')->take(10)->get();
            $admins = User::where('role_id', 1)->orderBy('created_at', 'DESC')->take(10)->get();
            
            return view('dashboard.index', compact('bumdes_count', 'investor_count', 'project_count', 'invest_count', 'bumdes', 'users', 'admins'));
        } else {
            $current_invest = Investment::whereHas('project', function ($query) {
                return $query
                    ->where('bumdes_id', auth()->user()->bumdes->id)
                    ->whereDate('offer_start_date', '<=', Carbon::now())
                    ->whereDate('offer_end_date', '>=', Carbon::now())
                    ->groupBy('bumdes_id');
            })->where('investment_status_id', 2)->sum('amount');
            $invest_target = Project::where('bumdes_id', auth()->user()->bumdes->id)
                ->whereDate('offer_start_date', '<=', Carbon::now())
                ->whereDate('offer_end_date', '>=', Carbon::now())
                ->groupBy('bumdes_id')
                ->sum('invest_target');
            $total_product = Project::where('bumdes_id', auth()->user()->bumdes->id)->count();
            $total_investor = Investment::whereHas('project', function ($query) {
                return $query->where('bumdes_id', auth()->user()->bumdes->id);
            })->where('investment_status_id', 2)->select('user_id')->distinct()->get()->makeVisible('user_id')->count();
            $products = Project::where('bumdes_id', auth()->user()->bumdes->id)->orderBy('created_at', 'DESC')->take(10)->get();
            $investments = Investment::whereHas('project', function ($query) {
                return $query->where('bumdes_id', auth()->user()->bumdes->id);
            })
                ->where('investment_status_id', 2)
                ->orderBy('created_at')
                ->take(10)
                ->get();

            return view('dashboard.index', compact('current_invest', 'invest_target', 'total_product', 'total_investor', 'products', 'investments'));
        }
    }

    public function download_review_qr()
    {
        $link = URL::to('/review/' . auth()->user()->bumdes->code);
        $qr = QrCode::format('svg')->size(500)->generate($link);

        return response($qr, 200, [
            'Content-Type' => 'image/svg',
        ],);
    }
}

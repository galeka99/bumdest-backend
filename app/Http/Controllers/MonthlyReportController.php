<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Bumdes;
use App\Models\Investment;
use App\Models\MonthlyReport;
use App\Models\MonthlyReportDetail;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::where('bumdes_id', auth()->user()->bumdes->id)->orderBy('created_at', 'DESC')->get(['id', 'title']);

        $limit = intval($request->input('limit', '25'));
        $reports = MonthlyReport::whereHas('project', function ($q) {
            return $q->where('bumdes_id', auth()->user()->bumdes->id);
        })
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);

        return view('dashboard.reports.index', compact('reports', 'projects'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product' => 'required|numeric',
            'periode' => 'required|date_format:Y-m',
            'income' => 'required|numeric',
        ]);

        $income = intval($request->post('income', '0'));
        if (auth()->user()->bumdes->balance < $income)
            return redirect('/reports')->with('error', 'Insufficient balance');
        
        $product = Project::where('id', $request->post('product'))->where('bumdes_id', auth()->user()->bumdes->id)->first();
        if (!$product) return redirect('/reports')->with('error', 'Product not found');

        $bumdes = Bumdes::find(auth()->user()->bumdes->id);
        $bumdes->balance -= $income;
        $bumdes->save();

        $report = MonthlyReport::create([
            'project_id' => $product->id,
            'month' => explode('-', $request->post('periode'))[1],
            'year' => explode('-', $request->post('periode'))[0],
            'profit' => $income,
        ]);

        if ($request->hasFile('report_file')) {
            $path = Helper::uploadFile('public/report', $request->file('report_file'));
            $report->report_file = $path;
            $report->save();
        }

        $investments = Investment::where('project_id', $product->id)->selectRaw('SUM(amount) as total, user_id')->groupBy('user_id')->get();
        foreach ($investments as $inv) {
            $percentage = $inv->total / $product->current_invest;
            $amount = $income * $percentage;

            MonthlyReportDetail::create([
                'monthly_report_id' => $report->id,
                'user_id' => $inv->user_id,
                'percentage' => $percentage * 100,
                'amount' => $amount,
            ]);

            $user = User::find($inv->user_id);
            $user->balance += $amount;
            $user->save();
        }

        return redirect('/reports')->with('success', 'Monthly report submitted');
    }

    public function detail(int $id)
    {
        $report = MonthlyReport::whereHas('project', function ($q) {
            return $q->where('bumdes_id', auth()->user()->bumdes->id);
        })
            ->where('id', $id)
            ->first();

        return view('dashboard.reports.detail', compact('report'));
    }
}

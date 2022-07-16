<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\MonthlyReportDetail;
use Illuminate\Http\Request;

class MonthlyReportApiController extends Controller
{
    public function list(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $reports = MonthlyReportDetail::where('user_id', $request->user->id)
            ->with(['parent:id,month,year,project_id', 'parent.project:id,title'])
            ->latest()
            ->paginate($limit);

        return Helper::sendJson(null, Helper::paginate($reports));
    }

    public function detail(Request $request, int $id)
    {
        $report = MonthlyReportDetail::where('id', $id)
            ->where('user_id', $request->user->id)
            ->with(['parent', 'parent.project:id,title,bumdes_id', 'parent.project.bumdes:id,name,district_id'])
            ->first();
        if (!$report) return Helper::sendJson('MONTHLY_REPORT_NOT_FOUND', null, 404);
        return Helper::sendJson(null, $report);
    }
}

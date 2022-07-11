<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WithdrawApiController extends Controller
{
    public function payment_method()
    {
        $methods = PaymentMethod::all();
        return Helper::sendJson(null, $methods, 200);
    }
    
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) return Helper::sendJson('INVALID_REQUEST', $validator->errors(), 400);

        $user = User::find($request->user->id);

        $method = PaymentMethod::find($request->post('method'));
        if (!$method) return Helper::sendJson('PAYMENT_METHOD_NOT_FOUND', null, 404);
        
        // ADD DEPOSIT RECORD
        $amount = intval($request->post('amount', '0'));

        if ($amount < 0) return Helper::sendJson('INVALID_AMOUNT', null, 400);
        if ($amount > $user->balance) return Helper::sendJson('INSUFFICIENT_BALANCE', null, 403);

        Withdraw::create([
            'amount' => $amount,
            'payment_method_id' => $method->id,
            'withdraw_status_id' => 2,
            'user_id' => $request->user->id,
        ]);

        // DECREASE USER BALANCE
        $user->balance -= $amount;
        $user->save();

        return Helper::sendJson(null, null);
    }

    public function history(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $history = Withdraw::where('user_id', $request->user->id)
            ->with(['method', 'status'])
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        
        return Helper::sendJson(null, Helper::paginate($history));
    }

    public function detail(Request $request, int $id)
    {
        $deposit = Withdraw::where('id', $id)
            ->where('user_id', $request->user->id)
            ->with(['method', 'status'])
            ->first();
        if (!$deposit) return Helper::sendJson('WITHDRAW_NOT_FOUND', null, 404);

        return Helper::sendJson(null, $deposit, 200);
    }
}

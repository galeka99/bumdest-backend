<?php

namespace App\Http\Controllers;

use App\Http\Helper;
use App\Models\Deposit;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class DepositApiController extends Controller
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

        $method = PaymentMethod::find($request->post('method'));
        if (!$method) return Helper::sendJson('PAYMENT_METHOD_NOT_FOUND', null, 404);
        
        // ADD DEPOSIT RECORD
        $payment_code = strtoupper(Str::random(16));
        $amount = intval($request->post('amount', '0'));

        if ($amount < 0) return Helper::sendJson('INVALID_AMOUNT', null, 400);

        Deposit::create([
            'amount' => $amount,
            'payment_method_id' => $method->id,
            'payment_code' => $payment_code,
            'deposit_status_id' => 2,
            'user_id' => $request->user->id,
        ]);

        // INCREASE USER BALANCE
        $user = User::find($request->user->id);
        $user->balance += $amount;
        $user->save();

        return Helper::sendJson(null, null);
    }

    public function history(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $history = Deposit::where('user_id', $request->user->id)
            ->with(['method', 'status'])
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        
        return Helper::sendJson(null, Helper::paginate($history));
    }

    public function detail(Request $request, int $id)
    {
        $deposit = Deposit::where('id', $id)
            ->where('user_id', $request->user->id)
            ->with(['method', 'status'])
            ->first();
        if (!$deposit) return Helper::sendJson('DEPOSIT_NOT_FOUND', null, 404);

        return Helper::sendJson(null, $deposit, 200);
    }
}

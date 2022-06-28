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
        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => $methods,
        ]);
    }

    public function request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => 'INVALID_REQUEST',
                'data' => $validator->errors(),
            ], 400);
        }

        $method = PaymentMethod::find($request->post('method'));
        if (!$method)
            return response()->json([
                'status' => 404,
                'error' => 'PAYMENT_METHOD_NOT_FOUND',
                'data' => null,
            ], 404);
        
        // ADD DEPOSIT RECORD
        $payment_code = strtoupper(Str::random(16));
        $amount = intval($request->post('amount', '0'));

        if ($amount < 0)
            return response()->json([
                'status' => 400,
                'error' => 'INVALID_AMOUNT',
                'data' => null,
            ], 400);

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

        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => null,
        ]);
    }

    public function history(Request $request)
    {
        $limit = intval($request->input('limit', '25'));
        $history = Deposit::where('user_id', $request->user->id)
            ->with(['method', 'status'])
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        
        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => Helper::paginate($history),
        ]);
    }

    public function detail(Request $request, int $id)
    {
        $deposit = Deposit::where('id', $id)
            ->where('user_id', $request->user->id)
            ->with(['method', 'status'])
            ->first();
        if (!$deposit)
            return response()->json([
                'status' => 404,
                'error' => 'DEPOSIT_NOT_FOUND',
                'data' => null,
            ], 404);

        return response()->json([
            'status' => 200,
            'error' => null,
            'data' => $deposit,
        ]);
    }
}

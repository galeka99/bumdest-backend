<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use App\Models\Deposit;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepositController extends Controller
{
    public function history(Request $request)
    {
        $methods = PaymentMethod::all();

        $limit = intval($request->input('limit', '25'));
        $deposits = Deposit::where('bumdes_id', auth()->user()->bumdes->id)
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);

        return view('dashboard.topup.index', compact('deposits', 'methods'));
    }

    public function request(Request $request)
    {
        $request->validate([
            'method' => 'required|numeric',
            'amount' => 'required|numeric|min:10000',
        ]);

        $amount = intval($request->post('amount'));
        $method = PaymentMethod::find($request->post('method'));
        if (!$method) return redirect('/topup')->with('error', 'Payment method not found');

        $payment_code = strtoupper(Str::random(16));

        Deposit::create([
            'amount' => $amount,
            'payment_method_id' => $method->id,
            'payment_code' => $payment_code,
            'deposit_status_id' => 2,
            'user_id' => auth()->user()->id,
            'bumdes_id' => auth()->user()->bumdes->id,
        ]);

        $bumdes = Bumdes::find(auth()->user()->bumdes->id);
        $bumdes->balance += $amount;
        $bumdes->save();

        return redirect('/topup')->with('success', 'Please follow our instructions to do the transaction, we will process your transaction approximately 5 minutes after we received the transaction');
    }
}

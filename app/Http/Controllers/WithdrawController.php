<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use App\Models\PaymentMethod;
use App\Models\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function history(Request $request)
    {
        $methods = PaymentMethod::all();

        $limit = intval($request->input('limit', '25'));
        $withdraws = Withdraw::where('bumdes_id', auth()->user()->bumdes->id)
            ->orderBy('created_at', 'DESC')
            ->paginate($limit);
        
        return view('dashboard.withdraw.index', compact('withdraws', 'methods'));
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

        $bumdes = Bumdes::find(auth()->user()->bumdes->id);
        if ($bumdes->balance < $amount) return redirect('/withdraw')->with('error', 'Insufficient balance to withdraw');

        Withdraw::create([
            'amount' => $amount,
            'payment_method_id' => $method->id,
            'withdraw_status_id' => 2,
            'user_id' => auth()->user()->id,
            'bumdes_id' => auth()->user()->bumdes->id,
        ]);

        $bumdes->balance -= $amount;
        $bumdes->save();

        return redirect('/withdraw')->with('success', 'We will contact you later for withdraw details, please wait for your turn to be processed. Thank you.');
    }
}

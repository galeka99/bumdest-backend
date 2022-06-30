<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'payment_method_id', 'withdraw_status_id', 'user_id', 'bumdes_id'];
    protected $hidden = ['payment_method_id', 'withdraw_status_id', 'user_id', 'bumdes_id'];

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(DepositStatus::class, 'withdraw_status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bumdes()
    {
        return $this->belongsTo(Bumdes::class, 'bumdes_id', 'id');
    }
}

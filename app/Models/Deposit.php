<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'payment_method_id', 'payment_code', 'deposit_status_id', 'user_id'];
    protected $hidden = ['payment_method_id', 'deposit_status_id', 'user_id'];

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(DepositStatus::class, 'deposit_status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

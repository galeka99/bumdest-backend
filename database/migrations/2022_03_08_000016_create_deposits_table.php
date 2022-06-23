<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amount')->default(0);
            $table->foreignId('payment_method_id')->default(1)->constrained('payment_methods')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('payment_code')->default('-');
            $table->foreignId('deposit_status_id')->default(1)->constrained('deposit_statuses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deposits');
    }
};

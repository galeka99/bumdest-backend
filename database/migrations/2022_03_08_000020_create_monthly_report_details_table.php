<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('monthly_report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monthly_report_id')->constrained('monthly_reports')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->double('percentage', 8, 2, true);
            $table->unsignedBigInteger('amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_report_details');
    }
};

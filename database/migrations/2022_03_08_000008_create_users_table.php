<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->unsignedBigInteger('balance')->default(0);
            $table->longText('address');
            $table->string('postal_code');
            $table->foreignId('district_id')->constrained('districts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('gender_id')->constrained('genders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_status_id')->constrained('user_statuses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('bumdes_id')->nullable()->constrained('bumdes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};

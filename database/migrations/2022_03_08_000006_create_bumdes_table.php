<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bumdes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->unsignedBigInteger('balance')->default(0);
            $table->foreignId('district_id')->constrained('districts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->longText('address');
            $table->string('postal_code');
            $table->longText('description');
            $table->string('maps_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bumdes');
    }
};

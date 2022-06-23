<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->unsignedBigInteger('invest_target')->default(0);
            $table->date('offer_start_date');
            $table->date('offer_end_date');
            $table->string('proposal_path')->nullable();
            $table->foreignId('bumdes_id')->constrained('bumdes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('project_statuses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};

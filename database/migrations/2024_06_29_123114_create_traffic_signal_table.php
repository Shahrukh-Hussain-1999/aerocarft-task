<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('traffic_signal', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('light_one_sequence');
            $table->string('light_two_sequence');
            $table->string('light_three_sequence');
            $table->string('light_four_sequence');
            $table->string('green_light_interval');
            $table->string('yellow_light_interval');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_signal');
    }
};

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
        Schema::create('showtime_screens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showtime_id');
            $table->unsignedBigInteger('screen_id');
            $table->foreign('showtime_id')->references('id')->on('show_times')->onDelete('cascade');
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showtime_screens');
    }
};

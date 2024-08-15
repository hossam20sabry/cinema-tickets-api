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
        Schema::create('show_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
	        $table->unsignedBigInteger('theater_id');
            $table->date('date');
            $table->Time('start_time');
            $table->Time('end_time');
            $table->timestamps();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('theater_id')->references('id')->on('theaters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('show_times');
    }
};

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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_time_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('screen_id');
            $table->integer('total_seats');
            $table->boolean('payment_status')->default(false);
            $table->enum('booking_status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->foreign('show_time_id')->references('id')->on('show_times')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

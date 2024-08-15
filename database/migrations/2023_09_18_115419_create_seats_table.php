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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('row_id');
            $table->string('number');
	        $table->string('price');
            $table->tinyInteger('apearance')->default(0); // 0 = appear, 1 = not appear
            $table->enum('type', ['standard', 'VIP'])->default('standard');
            $table->enum('status', ['booked', 'available','pending'])->default('available');
            $table->timestamps();
            $table->foreign('row_id')->references('id')->on('rows')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};

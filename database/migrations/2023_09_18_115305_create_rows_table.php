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
        Schema::create('rows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('screen_id');
            $table->string('letter');
            $table->integer('seats_count');
            $table->timestamps();
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rows');
    }
};

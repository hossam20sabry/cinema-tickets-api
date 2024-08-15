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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name')->nullable();
            $table->string('duration')->nullable();
            $table->string('director')->nullable();
            $table->string('lang')->nullable();
            $table->decimal('rating')->nullable();
            $table->string('explore')->default(0);
            $table->date('release_date')->nullable();
            $table->string('poster_url')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('trailer_url')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};

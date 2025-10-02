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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable(false);
            $table->decimal('price', 10, 2)->nullable(false);
            $table->integer('duration')->nullable(false);
            $table->enum('resolution', ['720p', '1080p', '4k'])->nullable(false);
            $table->integer('max_devices')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

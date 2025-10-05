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
            $table->string('title', 255)->nullable(false);
            $table->string('slug', 255)->nullable(false)->unique('unique_slug');
            $table->text('description')->nullable(false);
            $table->string('director', 255)->nullable(false);
            $table->string('writers', 200)->nullable(false);
            $table->string('stars', 255)->nullable(false);
            $table->string('poster', 255)->nullable(false);
            $table->date('release_date')->nullable(false);
            $table->integer('duration')->nullable(false);
            $table->string('url_720', 255)->nullable(false);
            $table->string('url_1080', 255)->nullable(false);
            $table->string('url_4k', 255)->nullable(false);
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

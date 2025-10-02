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
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('device_name', 100)->nullable(false);
            $table->string('device_id', 100)->nullable(false)->unique('device_id_unique');
            $table->string('device_type', 100)->nullable(true);
            $table->string('platform', 100)->nullable(true);
            $table->string('platform_version', 100)->nullable(true);
            $table->string('browser', 100)->nullable(true);
            $table->string('browser_version', 100)->nullable(true);
            $table->timestamp('last_active')->nullable(true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};

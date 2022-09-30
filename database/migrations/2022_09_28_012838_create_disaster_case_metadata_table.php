<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void {
        Schema::create('disaster_case_metadata', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->nullable();
            $table->unsignedBigInteger('disaster_case_id')->nullable();
            $table->json('casualties')->nullable();
            $table->json('raw')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::dropIfExists('disaster_case_metadata');
    }
};

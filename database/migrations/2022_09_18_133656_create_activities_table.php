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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->nullable();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('activity_type_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('activity_category')->default('comment')->nullable();
            $table->string('status')->default('active');
            $table->json('raw')->nullable();
            $table->unsignedBigInteger('activityable_id')->index();
            $table->string('activityable_type');
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
        Schema::dropIfExists('activities');
    }
};

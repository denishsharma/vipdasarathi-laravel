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
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('task_of_id')->nullable()->after('task_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('task_of_id');
        });
    }
};

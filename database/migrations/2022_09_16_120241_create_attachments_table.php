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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->unsignedBigInteger('attachmentable_id')->index();
            $table->string('attachmentable_type');
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
        Schema::dropIfExists('attachments');
    }
};

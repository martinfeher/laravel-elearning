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
        Schema::create('course_tags', function (Blueprint $table) {
            $table->integer('course_id');
            $table->integer('tag_id');
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['course_id', 'tag_id']);

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_tags');
    }
};

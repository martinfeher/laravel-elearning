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
        Schema::create('course_attribute_items', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->integer('attribute_id');
            $table->integer('attribute_item_id');
            $table->integer('attribute_item_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_attribute_items');
    }
};

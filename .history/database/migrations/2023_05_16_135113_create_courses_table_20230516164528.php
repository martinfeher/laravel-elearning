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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 2047)->nullable();
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->integer('product_number')->unique()->unsigned();
            $table->string('featured_image', 2047)->nullable();
            $table->float('price')->nullable();   
            $table->boolean('sale_price')->nullable();   
            $table->float('sale_price_value')->nullable();   
            $table->integer('stock_quantity')->nullable();   
            $table->boolean('reviews_allowed')->nullable();   
            $table->integer('rating_items')->nullable();   
            $table->integer('rating')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

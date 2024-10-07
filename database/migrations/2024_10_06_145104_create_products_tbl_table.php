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
        Schema::create('products_tbl', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned(); // ensure it matches the type
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('product_name', 255)->unique();
            $table->text('description');
            $table->integer('price'); 
            $table->integer('stock_quantity')->default(0); 
            $table->string('image', 255)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_tbl');
    }
};

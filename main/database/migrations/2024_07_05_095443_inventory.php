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
        //
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('product_code') ->unique();
            $table->string('product_name');
            $table->string('product_type');
            $table->string('size');
            $table->string('category');
            $table->string('quantity');
            $table->string('status')->nullable(); 
            $table->string('brand');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        //
        Schema::dropIfExists('inventory');
    }
};

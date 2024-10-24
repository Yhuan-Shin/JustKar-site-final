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

        Schema::table('sales', function (Blueprint $table) {
            //
            $table->string('transaction_no')->nullable();
        });
        Schema::table('refunds', function (Blueprint $table) {
            //
            $table->string('transaction_no')->nullable();
        });
        Schema::table('payment', function (Blueprint $table) {  
            //
            $table->string('transaction_no')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //

        Schema::table('sales', function (Blueprint $table) {
            //
            $table->dropColumn('transaction_no');
        });
        Schema::table('refunds', function (Blueprint $table) {
            //
            $table->dropColumn('transaction_no');
        });
        Schema::table('payment', function (Blueprint $table) {
            //
            $table->dropColumn('transaction_no');
        });
    }
};

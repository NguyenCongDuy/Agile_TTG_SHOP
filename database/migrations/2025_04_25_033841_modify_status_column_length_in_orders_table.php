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
        Schema::table('orders', function (Blueprint $table) {
            // Increase the length of the status column
            $table->string('status', 30)->change();
            // You might also want to ensure payment_status has enough length
            // $table->string('payment_status', 30)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Optional: Define how to revert the change if needed
            // You might revert to the previous length, but be careful
            // if data truncation could occur.
            // Example: Assuming previous length was 10
            // $table->string('status', 10)->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing processing orders to have a more specific status
        // This is safe because we're only updating processing orders, not completed or cancelled ones
        DB::statement("UPDATE orders SET status = 'processing' WHERE status = 'processing'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to do anything in down migration
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            // First, convert existing data
            DB::statement('UPDATE users SET role = CASE WHEN role = "admin" THEN 1 ELSE 0 END');
            
            // Then change the column type
            $table->boolean('role')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // First, convert back to string
            DB::statement('UPDATE users SET role = CASE WHEN role = 1 THEN "admin" ELSE "user" END');
            
            // Then change the column type back
            $table->string('role')->default('user')->change();
        });
    }
};

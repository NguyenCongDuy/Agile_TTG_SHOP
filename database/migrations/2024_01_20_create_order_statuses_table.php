<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Cập nhật dữ liệu hiện có để phù hợp với enum mới
        DB::statement("UPDATE orders SET payment_status = 'unpaid' WHERE payment_status = 'pending'");
        
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'pending',        // Chờ xác nhận
                'confirmed',      // Đã xác nhận
                'processing',     // Đang xử lý
                'shipping',       // Đang giao hàng
                'delivered',      // Đã giao hàng
                'completed',      // Hoàn thành
                'cancelled'       // Đã hủy
            ])->default('pending')->change();
            
            // Sau khi cập nhật dữ liệu, chuyển đổi cột thành enum
            DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('unpaid', 'processing', 'paid', 'refunded') NOT NULL DEFAULT 'unpaid'");
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->change();
            DB::statement("ALTER TABLE orders MODIFY payment_status VARCHAR(255) DEFAULT 'pending'");
        });
    }
};


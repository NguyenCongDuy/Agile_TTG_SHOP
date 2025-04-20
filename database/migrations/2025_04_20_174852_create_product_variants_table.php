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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique(); // Mã sản phẩm biến thể
            $table->decimal('price', 10, 2)->nullable(); // Giá riêng của biến thể (nếu khác giá gốc)
            $table->decimal('sale_price', 10, 2)->nullable(); // Giá khuyến mãi
            $table->integer('stock')->default(0); // Số lượng trong kho
            $table->string('image')->nullable(); // Ảnh riêng của biến thể
            $table->boolean('is_default')->default(false); // Có phải biến thể mặc định không
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

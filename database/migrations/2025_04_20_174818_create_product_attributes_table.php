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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Tên thuộc tính (màu sắc, kích thước, v.v.)
            $table->string('display_name'); // Tên hiển thị
            $table->string('type')->default('select'); // Loại thuộc tính (select, radio, color, v.v.)
            $table->boolean('is_required')->default(false); // Có bắt buộc chọn không
            $table->boolean('is_filterable')->default(false); // Có dùng để lọc sản phẩm không
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->integer('position')->default(0); // Vị trí hiển thị
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};

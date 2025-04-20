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
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_attribute_id')->constrained()->onDelete('cascade');
            $table->string('value'); // Giá trị của thuộc tính (ví dụ: Đỏ, Xanh, L, XL, v.v.)
            $table->string('display_value')->nullable(); // Giá trị hiển thị
            $table->string('color_code')->nullable(); // Mã màu nếu là thuộc tính màu sắc
            $table->integer('position')->default(0); // Vị trí hiển thị
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
};

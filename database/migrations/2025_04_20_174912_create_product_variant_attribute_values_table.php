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
        Schema::create('product_variant_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_attribute_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('attribute_value_id');
            $table->timestamps();

            // Manually define foreign key with shorter name
            $table->foreign('attribute_value_id', 'pv_attribute_value_fk')
                  ->references('id')
                  ->on('product_attribute_values')
                  ->onDelete('cascade');

            // Tạo index cho các cột khóa ngoại để tăng hiệu suất truy vấn
            $table->index(['product_variant_id', 'product_attribute_id'], 'pv_attr_idx');

            // Đảm bảo mỗi biến thể chỉ có một giá trị cho mỗi thuộc tính
            $table->unique(['product_variant_id', 'product_attribute_id'], 'pv_attr_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_attribute_values');
    }
};

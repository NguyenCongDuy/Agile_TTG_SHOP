<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Str;

class ProductVariantController extends Controller
{
    /**
     * Show the variants for a product.
     */
    public function index(Product $product)
    {
        $variants = $product->variants()->with('attributeValues.attribute')->paginate(10);
        $attributes = $product->attributes()->with('values')->get();

        return view('admin.products.variants.index', compact('product', 'variants', 'attributes'));
    }

    /**
     * Show the form for creating a new variant.
     */
    public function create(Product $product)
    {
        $attributes = $product->attributes()->with('values')->get();

        if ($attributes->isEmpty()) {
            return redirect()->route('admin.products.attributes', $product)
                ->with('error', 'Bạn cần thêm ít nhất một thuộc tính cho sản phẩm trước khi tạo biến thể.');
        }

        return view('admin.products.variants.create', compact('product', 'attributes'));
    }

    /**
     * Store a newly created variant in storage.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'sku' => 'required|string|max:255|unique:product_variants',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_default' => 'boolean',
            'attribute_values' => 'required|array',
            'attribute_values.*' => 'required|exists:product_attribute_values,id',
        ]);

        // Kiểm tra xem có biến thể mặc định nào khác không
        if ($request->is_default) {
            $product->variants()->where('is_default', true)->update(['is_default' => false]);
        }

        // Tạo biến thể mới
        $variant = new ProductVariant([
            'sku' => $request->sku,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
            'is_default' => $request->is_default ?? false,
            'is_active' => true,
        ]);

        // Xử lý hình ảnh nếu có
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($product->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products/variants'), $imageName);
            $variant->image = 'images/products/variants/' . $imageName;
        }

        // Lưu biến thể
        $product->variants()->save($variant);

        // Lưu các giá trị thuộc tính cho biến thể
        foreach ($request->attribute_values as $attributeId => $valueId) {
            $variant->attributeValues()->attach($valueId, ['product_attribute_id' => $attributeId]);
        }

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Biến thể sản phẩm đã được tạo thành công.');
    }

    /**
     * Show the form for editing the specified variant.
     */
    public function edit(Product $product, ProductVariant $variant)
    {
        // Kiểm tra xem biến thể có thuộc về sản phẩm này không
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $attributes = $product->attributes()->with('values')->get();
        $selectedValues = $variant->attributeValues()->pluck('product_attribute_value_id', 'product_attribute_id')->toArray();

        return view('admin.products.variants.edit', compact('product', 'variant', 'attributes', 'selectedValues'));
    }

    /**
     * Update the specified variant in storage.
     */
    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        // Kiểm tra xem biến thể có thuộc về sản phẩm này không
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $request->validate([
            'sku' => 'required|string|max:255|unique:product_variants,sku,' . $variant->id,
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'attribute_values' => 'required|array',
            'attribute_values.*' => 'required|exists:product_attribute_values,id',
        ]);

        // Kiểm tra xem có biến thể mặc định nào khác không
        if ($request->is_default && !$variant->is_default) {
            $product->variants()->where('is_default', true)->update(['is_default' => false]);
        }

        // Cập nhật biến thể
        $variant->sku = $request->sku;
        $variant->price = $request->price;
        $variant->sale_price = $request->sale_price;
        $variant->stock = $request->stock;
        $variant->is_default = $request->is_default ?? false;
        $variant->is_active = $request->is_active ?? true;

        // Xử lý hình ảnh nếu có
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($variant->image && file_exists(public_path($variant->image))) {
                unlink(public_path($variant->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($product->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products/variants'), $imageName);
            $variant->image = 'images/products/variants/' . $imageName;
        }

        $variant->save();

        // Cập nhật các giá trị thuộc tính cho biến thể
        $variant->attributeValues()->detach(); // Xóa các giá trị cũ

        foreach ($request->attribute_values as $attributeId => $valueId) {
            $variant->attributeValues()->attach($valueId, ['product_attribute_id' => $attributeId]);
        }

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Biến thể sản phẩm đã được cập nhật thành công.');
    }

    /**
     * Remove the specified variant from storage.
     */
    public function destroy(Product $product, ProductVariant $variant)
    {
        // Kiểm tra xem biến thể có thuộc về sản phẩm này không
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        // Xóa hình ảnh nếu có
        if ($variant->image && file_exists(public_path($variant->image))) {
            unlink(public_path($variant->image));
        }

        // Xóa biến thể
        $variant->delete();

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Biến thể sản phẩm đã được xóa thành công.');
    }
}

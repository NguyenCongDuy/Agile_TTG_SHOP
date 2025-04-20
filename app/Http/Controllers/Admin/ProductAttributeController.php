<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the product attributes.
     */
    public function index()
    {
        $attributes = ProductAttribute::orderBy('position')->paginate(10);
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new product attribute.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created product attribute in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_attributes',
            'display_name' => 'required|string|max:255',
            'type' => 'required|string|in:select,radio,color,text',
            'is_required' => 'boolean',
            'is_filterable' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $position = ProductAttribute::max('position') + 1;

        ProductAttribute::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'type' => $request->type,
            'is_required' => $request->is_required ?? false,
            'is_filterable' => $request->is_filterable ?? false,
            'is_active' => $request->is_active ?? true,
            'position' => $position,
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Thuộc tính sản phẩm đã được tạo thành công.');
    }

    /**
     * Show the form for editing the specified product attribute.
     */
    public function edit(ProductAttribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified product attribute in storage.
     */
    public function update(Request $request, ProductAttribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_attributes,name,' . $attribute->id,
            'display_name' => 'required|string|max:255',
            'type' => 'required|string|in:select,radio,color,text',
            'is_required' => 'boolean',
            'is_filterable' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $attribute->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'type' => $request->type,
            'is_required' => $request->is_required ?? false,
            'is_filterable' => $request->is_filterable ?? false,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Thuộc tính sản phẩm đã được cập nhật thành công.');
    }

    /**
     * Remove the specified product attribute from storage.
     */
    public function destroy(ProductAttribute $attribute)
    {
        // Kiểm tra xem thuộc tính có đang được sử dụng không
        if ($attribute->values()->count() > 0) {
            return redirect()->route('admin.attributes.index')
                ->with('error', 'Không thể xóa thuộc tính này vì nó đang được sử dụng.');
        }

        $attribute->delete();

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Thuộc tính sản phẩm đã được xóa thành công.');
    }

    /**
     * Update the position of the product attributes.
     */
    public function updatePositions(Request $request)
    {
        $request->validate([
            'positions' => 'required|array',
            'positions.*' => 'required|integer|exists:product_attributes,id',
        ]);

        foreach ($request->positions as $position => $id) {
            ProductAttribute::where('id', $id)->update(['position' => $position]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show the values for the specified product attribute.
     */
    public function values(ProductAttribute $attribute)
    {
        $values = $attribute->values()->orderBy('position')->get();
        return view('admin.attributes.values', compact('attribute', 'values'));
    }

    /**
     * Store a new value for the specified product attribute.
     */
    public function storeValue(Request $request, ProductAttribute $attribute)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'display_value' => 'nullable|string|max:255',
            'color_code' => 'nullable|string|max:7',
        ]);

        $position = $attribute->values()->max('position') + 1;

        $attribute->values()->create([
            'value' => $request->value,
            'display_value' => $request->display_value ?? $request->value,
            'color_code' => $attribute->type === 'color' ? $request->color_code : null,
            'position' => $position,
            'is_active' => true,
        ]);

        return redirect()->route('admin.attributes.values', $attribute)
            ->with('success', 'Giá trị thuộc tính đã được thêm thành công.');
    }

    /**
     * Update the specified product attribute value.
     */
    public function updateValue(Request $request, ProductAttributeValue $value)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'display_value' => 'nullable|string|max:255',
            'color_code' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        $value->update([
            'value' => $request->value,
            'display_value' => $request->display_value ?? $request->value,
            'color_code' => $value->attribute->type === 'color' ? $request->color_code : null,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.attributes.values', $value->attribute)
            ->with('success', 'Giá trị thuộc tính đã được cập nhật thành công.');
    }

    /**
     * Remove the specified product attribute value.
     */
    public function destroyValue(ProductAttributeValue $value)
    {
        $attribute = $value->attribute;

        // Kiểm tra xem giá trị có đang được sử dụng không
        if ($value->productVariants()->count() > 0) {
            return redirect()->route('admin.attributes.values', $attribute)
                ->with('error', 'Không thể xóa giá trị này vì nó đang được sử dụng.');
        }

        $value->delete();

        return redirect()->route('admin.attributes.values', $attribute)
            ->with('success', 'Giá trị thuộc tính đã được xóa thành công.');
    }
}

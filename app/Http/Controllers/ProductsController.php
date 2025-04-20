<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productList = Products::with('category')->paginate(10);
        return view('admin.products.index', compact('productList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Display inventory management page.
     */
    public function inventory()
    {
        return view('admin.products.inventory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'status' => 'boolean'
        ]);

        $product = new Products();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->is_featured = $request->is_featured ?? false;
        $product->status = $request->status ?? true;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được thêm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'status' => 'boolean'
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->is_featured = $request->is_featured ?? false;
        $product->status = $request->status ?? true;

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    } // <-- Đóng hàm tại đây


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        try {
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Show the attributes for a product.
     */
    public function attributes(Products $product)
    {
        $allAttributes = ProductAttribute::with('values')->orderBy('position')->get();
        $productAttributes = $product->attributes()->pluck('product_attribute_id')->toArray();

        return view('admin.products.attributes', compact('product', 'allAttributes', 'productAttributes'));
    }

    /**
     * Update the attributes for a product.
     */
    public function updateAttributes(Request $request, Products $product)
    {
        $request->validate([
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:product_attributes,id',
        ]);

        // Cập nhật thuộc tính sản phẩm
        $product->attributes()->sync($request->attributes ?? []);

        return redirect()->route('admin.products.attributes', $product)
            ->with('success', 'Thuộc tính sản phẩm đã được cập nhật thành công.');
    }
}

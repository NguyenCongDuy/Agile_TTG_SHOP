<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Đây là trang list của sản phẩm lấy từ controller';
        $productList = Products::all()->sortDesc();
        return view('admin.product.index', compact('productList', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('Đây là trang thêm');
    }

    /**
     * Display inventory management page.
     */
    public function inventory()
    {
        return view('admin.product.inventory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi xóa sản phẩm.');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier; // ✅ Import Alert model
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(['id', 'name']);
        $suppliers = Supplier::all(['id', 'name']);

        return view('admin.products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|max:255',
            'barcode' => 'nullable|unique:products',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|gt:cost_price',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $validated['stock_qty'] = 0;

        $product = Product::create($validated);

        // 🔔 Create alert
        Alert::create([
            'title' => 'Product Added',
            'message' => "Product '{$product->name}' has been added.",
            'type' => 'success',
            'is_read' => false,
        ]);

        return redirect()->back()
                         ->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all(['id', 'name']);
        $suppliers = Supplier::all(['id', 'name']);

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|max:255',
            'barcode' => 'nullable|unique:products,barcode,'.$product->id,
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|gt:cost_price',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $product->update($validated);

        // 🔔 Create alert
        Alert::create([
            'title' => 'Product Updated',
            'message' => "Product '{$product->name}' has been updated.",
            'type' => 'info',
            'is_read' => false,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $productName = $product->name;
        $product->delete();

        // 🔔 Create alert
        Alert::create([
            'title' => 'Product Deleted',
            'message' => "Product '{$productName}' has been deleted.",
            'type' => 'warning',
            'is_read' => false,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted.');
    }
}

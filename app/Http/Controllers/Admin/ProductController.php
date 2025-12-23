<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
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
            // Initial stock is typically handled by Purchase module, setting to 0 here
        ]);
        
        $validated['stock_qty'] = 0; 

        Product::create($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully. Remember to add stock via Purchases.');
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
            'barcode' => 'nullable|unique:products,barcode,' . $product->id, // Ignore current product's ID
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|gt:cost_price',
            'min_stock' => 'nullable|integer|min:0',
        ]);
        
        $product->update($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }
    
    public function destroy(Product $product)
    {
        // Deleting a product with sale/purchase history could break reports. 
        // In a real system, you'd soft delete. For now, we hard delete:
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
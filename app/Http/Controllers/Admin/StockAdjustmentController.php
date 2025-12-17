<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockAdjustment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = StockAdjustment::with(['product', 'user'])->latest()->get();
        return view('admin.stock_adjustments.index', compact('adjustments'));
    }
    
    public function create()
    {
        $products = Product::all(['id', 'name', 'stock_qty']);
        return view('admin.stock_adjustments.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:increase,decrease',
            'qty' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $product = Product::find($validated['product_id']);
        
        // Check for negative stock on decrease
        if ($validated['type'] == 'decrease' && $product->stock_qty < $validated['qty']) {
            return back()->with('error', 'Adjustment quantity exceeds current stock. Current stock: ' . $product->stock_qty);
        }

        // 1. Update the Product stock
        if ($validated['type'] == 'increase') {
            $product->increment('stock_qty', $validated['qty']);
        } else {
            $product->decrement('stock_qty', $validated['qty']);
        }

        // 2. Log the adjustment
        StockAdjustment::create([
            'product_id' => $validated['product_id'],
            'user_id' => Auth::id(), // Current logged-in user
            'type' => $validated['type'],
            'qty' => $validated['qty'],
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('admin.stock_adjustments.index')->with('success', 'Stock adjustment logged and inventory updated.');
    }
    
    // ... no need for edit/update/destroy in typical adjustment logs
}
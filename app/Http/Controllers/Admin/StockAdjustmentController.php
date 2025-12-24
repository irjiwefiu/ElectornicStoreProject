<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Product;
use App\Models\StockAdjustment; // ✅ Import Alert model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($validated['product_id']);

            if ($validated['type'] == 'decrease' && $product->stock_qty < $validated['qty']) {
                return back()->with('error', 'Insufficient stock for this decrease.');
            }

            // Update Stock
            $validated['type'] == 'increase'
                ? $product->increment('stock_qty', $validated['qty'])
                : $product->decrement('stock_qty', $validated['qty']);

            // Create Log
            $adjustment = StockAdjustment::create($validated + ['user_id' => Auth::id()]);

            DB::commit();

            // 🔔 Create alert
            Alert::create([
                'title' => 'Stock Adjustment Added',
                'message' => "Stock {$validated['type']} of {$validated['qty']} units for product '{$product->name}'. Reason: {$validated['reason']}.",
                'type' => 'success',
                'is_read' => false,
            ]);

            return redirect()->route('admin.stock_adjustments.index')->with('success', 'Adjustment saved.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    public function edit(StockAdjustment $stockAdjustment)
    {
        $products = Product::all(['id', 'name', 'stock_qty']);

        return view('admin.stock_adjustments.edit', compact('stockAdjustment', 'products'));
    }

    public function update(Request $request, StockAdjustment $stockAdjustment)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:increase,decrease',
            'qty' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // REVERT old stock change
            $oldProduct = Product::findOrFail($stockAdjustment->product_id);
            if ($stockAdjustment->type == 'increase') {
                $oldProduct->decrement('stock_qty', $stockAdjustment->qty);
            } else {
                $oldProduct->increment('stock_qty', $stockAdjustment->qty);
            }

            // APPLY new stock change
            $newProduct = Product::findOrFail($validated['product_id']);
            if ($validated['type'] == 'decrease' && $newProduct->stock_qty < $validated['qty']) {
                DB::rollBack();

                return back()->with('error', 'New adjustment would result in negative stock.');
            }

            $validated['type'] == 'increase'
                ? $newProduct->increment('stock_qty', $validated['qty'])
                : $newProduct->decrement('stock_qty', $validated['qty']);

            // Update Log
            $stockAdjustment->update($validated + ['user_id' => Auth::id()]);

            DB::commit();

            // 🔔 Create alert
            Alert::create([
                'title' => 'Stock Adjustment Updated',
                'message' => "Adjustment updated: {$validated['type']} {$validated['qty']} units for product '{$newProduct->name}'. Reason: {$validated['reason']}.",
                'type' => 'info',
                'is_read' => false,
            ]);

            return redirect()->route('admin.stock_adjustments.index')->with('success', 'Adjustment updated and stock corrected.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Update failed: '.$e->getMessage());
        }
    }

    public function destroy(StockAdjustment $stockAdjustment)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($stockAdjustment->product_id);

            if ($stockAdjustment->type == 'increase') {
                $product->decrement('stock_qty', $stockAdjustment->qty);
            } else {
                $product->increment('stock_qty', $stockAdjustment->qty);
            }

            $stockAdjustment->delete();

            DB::commit();

            // 🔔 Create alert
            Alert::create([
                'title' => 'Stock Adjustment Deleted',
                'message' => "Adjustment deleted: {$stockAdjustment->type} {$stockAdjustment->qty} units for product '{$product->name}'.",
                'type' => 'warning',
                'is_read' => false,
            ]);

            return redirect()->route('admin.stock_adjustments.index')->with('success', 'Adjustment deleted and stock reverted.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Delete failed.');
        }
    }
}

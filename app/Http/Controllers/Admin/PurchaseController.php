<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier; // ✅ Import Alert model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    // List all purchases
    public function index()
    {
        $purchases = Purchase::with('supplier')
            ->latest()
            ->get();

        return view('admin.purchases.index', compact('purchases'));
    }

    // Show create purchase form
    public function create()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $products = Product::select('id', 'name', 'cost_price')->get();

        return view('admin.purchases.create', compact('suppliers', 'products'));
    }

    // Store purchase and update stock
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_no' => 'required|unique:purchases,invoice_no',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = collect($request->items)->sum(fn ($item) => $item['qty'] * $item['cost_price']);

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'invoice_no' => $request->invoice_no,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $totalAmount,
            ]);

            foreach ($request->items as $item) {
                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $item['qty'] * $item['cost_price'],
                ]);

                Product::where('id', $item['product_id'])->increment('stock_qty', $item['qty']);
            }

            DB::commit();

            // 🔔 Create alert
            Alert::create([
                'title' => 'Purchase Added',
                'message' => "Purchase #{$purchase->invoice_no} saved successfully with total {$purchase->total_amount}.",
                'type' => 'success',
                'is_read' => false,
            ]);

            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase saved and stock updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Purchase failed: '.$e->getMessage());
        }
    }

    // Show single purchase details
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);

        return view('admin.purchases.show', compact('purchase'));
    }

    // Show edit form
    public function edit(Purchase $purchase)
    {
        $purchase->load('items');
        $suppliers = Supplier::select('id', 'name')->get();
        $products = Product::select('id', 'name', 'cost_price')->get();

        return view('admin.purchases.edit', compact('purchase', 'suppliers', 'products'));
    }

    // Update purchase
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_no' => 'required|unique:purchases,invoice_no,'.$purchase->id,
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            foreach ($purchase->items as $oldItem) {
                Product::where('id', $oldItem->product_id)->decrement('stock_qty', $oldItem->qty);
            }

            $purchase->items()->delete();

            $totalAmount = collect($request->items)->sum(fn ($item) => $item['qty'] * $item['cost_price']);

            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'invoice_no' => $request->invoice_no,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $totalAmount,
            ]);

            foreach ($request->items as $item) {
                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $item['qty'] * $item['cost_price'],
                ]);

                Product::where('id', $item['product_id'])->increment('stock_qty', $item['qty']);
            }

            DB::commit();

            // 🔔 Create alert
            Alert::create([
                'title' => 'Purchase Updated',
                'message' => "Purchase #{$purchase->invoice_no} updated successfully.",
                'type' => 'info',
                'is_read' => false,
            ]);

            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase updated and inventory adjusted.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Update failed: '.$e->getMessage());
        }
    }

    // Delete purchase and revert stock
    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();

        try {
            foreach ($purchase->items as $item) {
                Product::where('id', $item->product_id)->decrement('stock_qty', $item->qty);
            }

            $purchase->items()->delete();
            $purchase->delete();

            DB::commit();

            // 🔔 Create alert
            Alert::create([
                'title' => 'Purchase Deleted',
                'message' => "Purchase #{$purchase->invoice_no} deleted and stock reverted.",
                'type' => 'warning',
                'is_read' => false,
            ]);

            return redirect()->route('admin.purchases.index')
                ->with('success', 'Purchase deleted and stock reverted.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Delete failed: '.$e->getMessage());
        }
    }

    // --- Custom Returns Methods ---
    public function createReturn()
    {
        return view('admin.purchases.returns.create');
    }

    public function storeReturn(Request $request)
    {
        // Add logic for storing return
    }
}

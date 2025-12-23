<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
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
            // 1️⃣ Calculate total
            $totalAmount = collect($request->items)->sum(function ($item) {
                return $item['qty'] * $item['cost_price'];
            });

            // 2️⃣ Create purchase
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'invoice_no' => $request->invoice_no,
                'purchase_date' => $request->purchase_date,
                'total_amount' => $totalAmount,
            ]);

            // 3️⃣ Save items & update stock
            foreach ($request->items as $item) {
                // Save purchase item
                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'cost_price' => $item['cost_price'],
                    'subtotal' => $item['qty'] * $item['cost_price'],
                ]);

                // 🔥 Guaranteed stock update
                $product = Product::findOrFail($item['product_id']);
                $product->stock_qty += $item['qty'];
                $product->save();
            }

            DB::commit();

            return redirect()
                ->route('admin.purchases.index')
                ->with('success', 'Purchase saved and stock updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Purchase failed: '.$e->getMessage());
        }
    }
}

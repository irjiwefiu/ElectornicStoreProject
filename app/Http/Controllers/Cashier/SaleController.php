<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Sales history (Cashier).
     */
    public function index()
    {
        $sales = Sale::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('cashier.sales.index', compact('sales'));
    }

    /**
     * POS Screen.
     */
    public function create()
    {
        $products = Product::where('stock_qty', '>', 0)
            ->get(['id', 'name', 'sale_price', 'stock_qty', 'barcode']);

        return view('cashier.sales.create', compact('products'));
    }

    /**
     * Store Sale.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.sale_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
        ]);

        // ✅ Correct invoice number
        $invoice_no = 'INV-'.date('Ymd').'-'.(Sale::count() + 1);

        DB::beginTransaction();

        try {
            /*
             * 1️⃣ Stock validation
             */
            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if ($product->stock_qty < $item['qty']) {
                    throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->stock_qty}");
                }
            }

            /**
             * 2️⃣ Create Sale.
             */
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'invoice_no' => $invoice_no,
                'subtotal' => $request->subtotal,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'total' => $request->total,
                'paid_amount' => $request->paid_amount,
                'change_return' => $request->paid_amount - $request->total,
            ]);

            /*
             * 3️⃣ Create Sale Items + Update Stock
             */
            foreach ($request->items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['sale_price'],
                    'subtotal' => $item['qty'] * $item['sale_price'],
                ]);

                Product::where('id', $item['product_id'])
                    ->decrement('stock_qty', $item['qty']);
            }

            DB::commit();

            return redirect()
                ->route('cashier.sales.invoice', $sale->id)
                ->with('success', 'Sale completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Invoice / Receipt.
     */
    public function invoice(Sale $sale)
    {
        $sale->load(['user', 'items.product']);

        return view('cashier.sales.invoice', compact('sale'));
    }
}

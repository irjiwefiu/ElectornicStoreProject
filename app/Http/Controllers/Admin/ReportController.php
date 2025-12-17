<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- CRITICAL: Import the DB Facade to fix \DB::raw error
use App\Models\Sale;
use App\Models\Product;
use App\Models\Purchase;

class ReportController extends Controller
{
       /* Reports landing page (used by navbar)
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Show the Daily Sales Report.
     */
    public function dailySales()
    {
        // Fetches all sales records created today.
        $dailySales = Sale::whereDate('created_at', today())
                          ->with('user') // Eager load the cashier who made the sale
                          ->get();

        return view('admin.reports.daily_sales', compact('dailySales'));
    }

    /**
     * Show the Inventory Health Report (Low Stock and Zero Stock).
     */
    public function inventoryHealth()
    {
        // Fetches products where current stock is less than or equal to the minimum stock level.
        $lowStock = Product::whereColumn('stock_qty', '<=', 'min_stock')
                           ->with(['category', 'supplier']) // Eager load relationships for the view
                           ->orderBy('stock_qty')
                           ->get();

        // Fetches products with exactly zero stock.
        $zeroStock = Product::where('stock_qty', 0)
                            ->with(['category', 'supplier'])
                            ->get();

        return view('admin.reports.inventory_health', compact('lowStock', 'zeroStock'));
    }

    /**
     * Show the Summary of Purchases grouped by Supplier.
     */
    public function supplierPurchases()
    {
        // Groups purchases by supplier_id, calculating the sum of total_amount and count of invoices.
        $supplierPurchases = Purchase::with('supplier')
            ->select(
                'supplier_id', 
                DB::raw('SUM(total_amount) as total_spent'),  // <-- FIXED: Using imported DB::raw
                DB::raw('COUNT(id) as total_invoices')        // <-- FIXED: Using imported DB::raw
            )
            ->groupBy('supplier_id')
            ->orderByDesc('total_spent') // Order by who we spent the most money with
            ->get();
            
        return view('admin.reports.supplier_purchases', compact('supplierPurchases'));
    }
}
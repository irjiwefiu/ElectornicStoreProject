<?php

use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\CategoryController;
// Admin Controllers
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StockAdjustmentController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Cashier\SaleController;
// Cashier Controllers
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (PUBLIC)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::delete('alerts/{alert}', [AlertController::class, 'destroy'])->name('alerts.destroy');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect (AFTER LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.categories.index');
    }

    return redirect()->route('cashier.sales.create');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Resources
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('products', ProductController::class);

        Route::resource('stock_adjustments', StockAdjustmentController::class)
         ->except(['show']); // We now allow edit, update, and destroy

        // --- PURCHASE ROUTES ---

        // 1. Custom/Specific routes MUST come before the resource wildcard
        Route::get('purchases/returns/create', [PurchaseController::class, 'createReturn'])
            ->name('purchases.returns.create');

        Route::post('purchases/returns', [PurchaseController::class, 'storeReturn'])
            ->name('purchases.returns.store');

        // 2. Standard Resource
        // FIX: Removed ->only(...) so 'edit', 'update', and 'destroy' are now created
        Route::resource('purchases', PurchaseController::class);

        // --- REPORT ROUTES ---
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('daily-sales', [ReportController::class, 'dailySales'])->name('daily_sales');
            Route::get('inventory-health', [ReportController::class, 'inventoryHealth'])->name('inventory_health');
            Route::get('supplier-purchases', [ReportController::class, 'supplierPurchases'])->name('supplier_purchases');
        });
    });

/*
|--------------------------------------------------------------------------
| CASHIER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:cashier'])
    ->prefix('cashier')
    ->name('cashier.')
    ->group(function () {
        // POS
        Route::get('/pos', [SaleController::class, 'create'])
            ->name('sales.create');

        Route::post('/pos/checkout', [SaleController::class, 'store'])
            ->name('sales.store');

        // Invoice
        Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])
            ->name('sales.invoice');

        // Sales History
        Route::get('/sales/history', [SaleController::class, 'index'])
            ->name('sales.index');
    });

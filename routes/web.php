<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (PUBLIC)
|--------------------------------------------------------------------------
| Breeze / Auth routes: /login, /register, /logout, etc.
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
| Let Laravel handle auth redirects
*/
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect (AFTER LOGIN)
|--------------------------------------------------------------------------
| Single place to decide admin vs cashier
*/
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user(); // Facade resolves null-safety better

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
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StockAdjustmentController;
use App\Http\Controllers\Admin\SupplierController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('products', ProductController::class);

        Route::resource('stock_adjustments', StockAdjustmentController::class)
            ->except(['edit', 'update', 'show']);

        Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('purchases', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::get('purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');

        Route::get('purchases/returns/create', [PurchaseController::class, 'createReturn'])
            ->name('purchases.returns.create');
        Route::post('purchases/returns', [PurchaseController::class, 'storeReturn'])
            ->name('purchases.returns.store');

        Route::prefix('reports')->name('reports.')->group(function () {
            // 👇 NEW index route (landing page for Reports)
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
use App\Http\Controllers\Cashier\SaleController;

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

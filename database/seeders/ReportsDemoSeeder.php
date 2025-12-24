<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Arr;

class ReportsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder will generate demo data for the last 3 months (90 days):
     * - Ensure a few users, suppliers and products exist
     * - Create many sales spread across the last 90 days with realistic timestamps
     * - Create purchases spread across the same period to drive supplier reports
     */
    public function run()
    {
        $faker = Faker::create();
        $today = Carbon::today();
        $days = 90; // last three months ≈ 90 days

        // Ensure there are some users (cashiers)
        if (User::count() < 3) {
            User::factory()->count(3 - User::count())->create();
        }
        $users = User::all();

        // Ensure some suppliers
        if (Supplier::count() < 5) {
            for ($i = 0; $i < 5 - Supplier::count(); $i++) {
                Supplier::create([
                    'name' => $faker->company,
                    'phone' => $faker->phoneNumber,
                    'email' => $faker->unique()->safeEmail,
                    'address' => $faker->address,
                ]);
            }
        }
        $suppliers = Supplier::all();

        // Ensure categories exist (products table requires category_id)
        if (Category::count() < 3) {
            Category::insert([
                ['name' => 'Laptops', 'description' => 'All laptops'],
                ['name' => 'Accessories', 'description' => 'Computer accessories'],
                ['name' => 'Mobiles', 'description' => 'Smartphones'],
            ]);
        }
        $categories = Category::all();

        // Ensure some products
        if (Product::count() < 20) {
            for ($i = 0; $i < 20 - Product::count(); $i++) {
                Product::create([
                    'category_id' => $categories->random()->id,
                    'supplier_id' => $suppliers->random()->id,
                    'name' => $faker->word . ' ' . $faker->word,
                    'barcode' => (string) $faker->unique()->numberBetween(1000000000, 9999999999),
                    'cost_price' => $cost = $faker->numberBetween(1000, 20000),
                    'sale_price' => $cost + $faker->numberBetween(200, 5000),
                    'stock_qty' => $faker->numberBetween(0, 200),
                    'min_stock' => $faker->numberBetween(1, 10),
                    'warranty_months' => $faker->numberBetween(0, 24),
                ]);
            }
        }
        $products = Product::all();

        // Seed sales for each day in the past 90 days
        for ($d = 0; $d < $days; $d++) {
            $date = $today->copy()->subDays($d);

            // Randomly decide how busy the day is
            $salesCount = $faker->numberBetween(3, 15);

            for ($s = 0; $s < $salesCount; $s++) {
                $saleTime = $date->copy()->addSeconds($faker->numberBetween(0, 86400));

                $itemsCount = $faker->numberBetween(1, 5);
                $subtotal = 0;
                $saleItems = [];

                for ($i = 0; $i < $itemsCount; $i++) {
                    $product = $products->random();
                    $qty = $faker->numberBetween(1, 3);
                    $price = $product->sale_price;
                    $lineSubtotal = $qty * $price;

                    $saleItems[] = [
                        'product_id' => $product->id,
                        'qty' => $qty,
                        'price' => $price,
                        'subtotal' => $lineSubtotal,
                    ];

                    $subtotal += $lineSubtotal;

                    // Slightly adjust product stock if present
                    if (!is_null($product->stock_qty)) {
                        $product->decrement('stock_qty', $qty);
                    }
                }

                $discount = round($subtotal * ($faker->numberBetween(0, 5) / 100), 2); // 0-5%
                $tax = round($subtotal * ($faker->numberBetween(0, 13) / 100), 2); // 0-13%
                $total = round($subtotal - $discount + $tax, 2);

                $sale = Sale::create([
                    'user_id' => $users->random()->id,
                    'invoice_no' => strtoupper(Str::random(8)),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total,
                    'paid_amount' => $total,
                    'change_return' => 0,
                    'created_at' => $saleTime,
                    'updated_at' => $saleTime,
                ]);

                foreach ($saleItems as $si) {
                    $si['sale_id'] = $sale->id;
                    SaleItem::create($si);
                }
            }
        }

        // Seed purchases across the period (roughly weekly purchases)
        $weeks = intdiv($days, 7);
        for ($w = 0; $w <= $weeks; $w++) {
            $weekDate = $today->copy()->subWeeks($w);
            $purchasesCount = $faker->numberBetween(1, 3);

            for ($p = 0; $p < $purchasesCount; $p++) {
                $purchaseTime = $weekDate->copy()->subDays($faker->numberBetween(0,6))->addSeconds($faker->numberBetween(0,86400));

                $itemsCount = $faker->numberBetween(1, 6);
                $subtotal = 0;
                $purchaseItems = [];

                for ($i = 0; $i < $itemsCount; $i++) {
                    $product = $products->random();
                    $qty = $faker->numberBetween(1, 20);
                    $cost = max(50, (int)($product->cost_price * (0.8 + $faker->randomFloat(2, 0, 0.4))));
                    $lineSubtotal = $qty * $cost;

                    $purchaseItems[] = [
                        'product_id' => $product->id,
                        'qty' => $qty,
                        'cost_price' => $cost,
                        'subtotal' => $lineSubtotal,
                    ];

                    $subtotal += $lineSubtotal;

                    // Increase product stock when purchased
                    if (!is_null($product->stock_qty)) {
                        $product->increment('stock_qty', $qty);
                    }
                }

                $purchase = Purchase::create([
                    'supplier_id' => $suppliers->random()->id,
                    'invoice_no' => strtoupper('P' . Str::random(7)),
                    'purchase_date' => $purchaseTime,
                    'total_amount' => $subtotal,
                    'created_at' => $purchaseTime,
                    'updated_at' => $purchaseTime,
                ]);

                foreach ($purchaseItems as $pi) {
                    $pi['purchase_id'] = $purchase->id;
                    PurchaseItem::create($pi);
                }
            }
        }
    }
}

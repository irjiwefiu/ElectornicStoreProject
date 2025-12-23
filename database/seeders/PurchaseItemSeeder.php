<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Database\Seeder;

class PurchaseItemSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch an existing purchase and product safely
        $purchase = Purchase::first();
        $product = Product::first();

        // Prevent FK crash if tables are empty
        if (!$purchase || !$product) {
            $this->command?->warn('PurchaseItemSeeder skipped: missing purchases or products.');

            return;
        }

        $qty = 5;
        $cost = $product->cost_price;

        PurchaseItem::create([
            'purchase_id' => $purchase->id,
            'product_id' => $product->id,
            'qty' => $qty,
            'cost_price' => $cost,
            'subtotal' => $qty * $cost,
        ]);
    }
}

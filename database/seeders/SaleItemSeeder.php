<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Seeder;

class SaleItemSeeder extends Seeder
{
    public function run(): void
    {
        $sale = Sale::first();
        $product = Product::first();

        // SAFETY CHECK
        if (!$sale || !$product) {
            return;
        }

        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'qty' => 1,
            'price' => $product->sale_price,
            'subtotal' => $product->sale_price,
        ]);
    }
}

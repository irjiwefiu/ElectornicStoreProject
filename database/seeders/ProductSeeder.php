<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'category_id' => 1,
                'supplier_id' => 1,
                'name' => 'Dell XPS 13',
                'barcode' => 'DXPS13',
                'cost_price' => 800,
                'sale_price' => 1000,
                'stock_qty' => 20,
                'min_stock' => 5,
                'warranty_months' => 12,
            ],
            [
                'category_id' => 2,
                'supplier_id' => 2,
                'name' => 'Wireless Mouse',
                'barcode' => 'MOUSE123',
                'cost_price' => 10,
                'sale_price' => 25,
                'stock_qty' => 50,
                'min_stock' => 10,
                'warranty_months' => 0,
            ],
        ]);
    }
}

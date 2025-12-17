<?php

namespace Database\Seeders;

use App\Models\StockAdjustment;
use Illuminate\Database\Seeder;

class StockAdjustmentSeeder extends Seeder
{
    public function run(): void
    {
        StockAdjustment::create([
            'product_id' => 1,
            'user_id' => 1,
            'type' => 'increase',
            'qty' => 5,
            'reason' => 'Initial stock correction',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        Purchase::create([
            'supplier_id' => 1,
            'invoice_no' => 'PUR-1001',
            'purchase_date' => now(),
            'total_amount' => 1600,
        ]);
    }
}

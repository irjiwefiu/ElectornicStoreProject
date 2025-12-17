<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $cashier = User::where('role', 'cashier')->first();

        Sale::create([
            'user_id' => $cashier->id,
            'invoice_no' => 'SAL-1001',
            'subtotal' => 1000,
            'discount' => 0,
            'tax' => 50,
            'total' => 1050,
            'paid_amount' => 1100,
            'change_return' => 50,
        ]);
    }
}

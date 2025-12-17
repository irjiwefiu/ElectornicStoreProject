<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::insert([
            [
                'name' => 'Global Tech Supply',
                'phone' => '123-555-0101',
                'email' => 'contact@global.com',
                'address' => 'USA',
            ],
            [
                'name' => 'Mega Components Inc',
                'phone' => '987-555-0202',
                'email' => 'sales@mega.com',
                'address' => 'Germany',
            ],
        ]);
    }
}

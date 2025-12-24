<?php

namespace Database\Seeders;

use App\Models\Alert;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alerts = [
            [
                'title' => 'System Startup',
                'message' => 'The system has been initialized successfully.',
                'type' => 'info',
                'is_read' => false,
            ],
            [
                'title' => 'New Product Added',
                'message' => 'Product "Laptop Pro 15" has been added to inventory.',
                'type' => 'success',
                'is_read' => false,
            ],
            [
                'title' => 'Low Stock Warning',
                'message' => 'Stock for "Wireless Mouse" has dropped below minimum threshold.',
                'type' => 'warning',
                'is_read' => false,
            ],
            [
                'title' => 'Supplier Deleted',
                'message' => 'Supplier "Tech Supplies Ltd." has been removed.',
                'type' => 'error',
                'is_read' => false,
            ],
            [
                'title' => 'Purchase Recorded',
                'message' => 'Purchase invoice #INV-1001 has been saved.',
                'type' => 'success',
                'is_read' => false,
            ],
            [
                'title' => 'Stock Adjustment',
                'message' => 'Stock increased by 50 units for "Keyboard".',
                'type' => 'info',
                'is_read' => false,
            ],
            [
                'title' => 'Category Updated',
                'message' => 'Category "Electronics" has been updated.',
                'type' => 'info',
                'is_read' => false,
            ],
            [
                'title' => 'Product Deleted',
                'message' => 'Product "Old Monitor" has been deleted.',
                'type' => 'warning',
                'is_read' => false,
            ],
            [
                'title' => 'Supplier Added',
                'message' => 'Supplier "Global Tech" has been added.',
                'type' => 'success',
                'is_read' => false,
            ],
            [
                'title' => 'Purchase Updated',
                'message' => 'Purchase invoice #INV-1002 has been updated.',
                'type' => 'info',
                'is_read' => false,
            ],
            [
                'title' => 'Stock Decrease',
                'message' => 'Stock decreased by 20 units for "Smartphone".',
                'type' => 'warning',
                'is_read' => false,
            ],
            [
                'title' => 'System Alert',
                'message' => 'Scheduled maintenance will occur at midnight.',
                'type' => 'info',
                'is_read' => false,
            ],
            [
                'title' => 'Critical Error',
                'message' => 'Database connection failed temporarily.',
                'type' => 'error',
                'is_read' => false,
            ],
            [
                'title' => 'Product Restocked',
                'message' => 'Product "Gaming Mouse" has been restocked.',
                'type' => 'success',
                'is_read' => false,
            ],
            [
                'title' => 'Supplier Updated',
                'message' => 'Supplier "Tech World" contact info updated.',
                'type' => 'info',
                'is_read' => false,
            ],
            [
                'title' => 'Purchase Deleted',
                'message' => 'Purchase invoice #INV-1003 has been deleted.',
                'type' => 'warning',
                'is_read' => false,
            ],
            [
                'title' => 'Stock Adjustment Error',
                'message' => 'Attempted stock decrease exceeded available quantity.',
                'type' => 'error',
                'is_read' => false,
            ],
            [
                'title' => 'System Notification',
                'message' => 'New update available for the application.',
                'type' => 'info',
                'is_read' => false,
            ],
            [
                'title' => 'Product Updated',
                'message' => 'Product "Tablet X" has been updated.',
                'type' => 'info',
                'is_read' => false,
            ],
            [
                'title' => 'Supplier Removed',
                'message' => 'Supplier "Office Supplies Co." has been removed.',
                'type' => 'warning',
                'is_read' => false,
            ],
        ];

        foreach ($alerts as $alert) {
            Alert::create($alert);
        }
    }
}

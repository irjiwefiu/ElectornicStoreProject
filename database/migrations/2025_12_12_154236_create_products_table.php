<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// ... inside the class
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys (with constraints for data integrity)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            
            // Product Details
            $table->string('name', 255);
            $table->string('barcode', 50)->unique()->nullable();
            $table->decimal('cost_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            
            // Inventory Details
            $table->integer('stock_qty')->default(0);
            $table->integer('min_stock')->default(5);
            $table->integer('warranty_months')->default(0);
            
            $table->timestamps();
        });
    }

public function down(): void
{
    Schema::dropIfExists('products');
}
};

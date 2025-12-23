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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict'); // Cashier who made the sale
            $table->string('invoice_no', 50)->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('change_return', 10, 2)->default(0.00);
            $table->timestamps(); // Used for sale_date/time
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

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
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict'); // To track who did it
            $table->enum('type', ['increase', 'decrease']);
            $table->integer('qty');
            $table->string('reason', 255);
            $table->timestamps(); // Use timestamps for adjustment_date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};

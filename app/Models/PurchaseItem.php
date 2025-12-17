<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_id', 'product_id', 'qty', 'cost_price', 'subtotal'];

    // Belongs to one Purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Belongs to one Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
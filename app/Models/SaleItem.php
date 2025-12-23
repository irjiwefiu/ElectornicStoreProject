<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'product_id', 'qty', 'price', 'subtotal'];

    // Belongs to one Sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Belongs to one Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
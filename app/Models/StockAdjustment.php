<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'type', 'qty', 'reason'];

    // Belongs to one Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Belongs to the User who made the adjustment
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
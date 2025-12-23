<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'invoice_no', 'subtotal', 'discount', 
        'tax', 'total', 'paid_amount', 'change_return'
    ];
    // timestamps will handle the sale_date/time

    // Belongs to one User (Cashier)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Has many Sale Items (the line items of the invoice)
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
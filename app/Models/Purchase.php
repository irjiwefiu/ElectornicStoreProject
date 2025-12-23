<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'invoice_no', 'purchase_date', 'total_amount'];
    
    protected $casts = [
        'purchase_date' => 'date',
    ];

    // Belongs to one Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Has many Purchase Items (the line items of the invoice)
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
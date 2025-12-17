<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'supplier_id', 'name', 'barcode', 
        'cost_price', 'sale_price', 'stock_qty', 'min_stock', 'warranty_months'
    ];

    // Relationships (BelongsTo):
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    // Relationships (HasMany / Pivot Tables):
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
    
    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }
}
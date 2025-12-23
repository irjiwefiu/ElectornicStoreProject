<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'address'];

    // Relationship: One Supplier supplies many Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    // Relationship: One Supplier is associated with many Purchases
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
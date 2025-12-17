<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Added for project roles
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    // Relationship: A User (Cashier) can make many Sales
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    
    // Relationship: A User (Admin) can log many Stock Adjustments
    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
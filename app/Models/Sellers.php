<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasRoles;

class Sellers extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $guard = 'seller';
    protected $table = 'sellers';

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'gst_number',
        'pan_number',
        'bank_account_number',
        'bank_name',
        'ifsc_code',
        'upi_id',
        'compliance_status',
        'bank_verified',
        'logo',
        'documents',
        'commission_rate',
        'is_active',
        'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'documents' => 'array',
        'is_active' => 'boolean',
    ];


    public function products()
    {
        return $this->hasMany(Products::class, 'seller_id');
    }

    public function activeOrders()
    {
        return $this->hasManyThrough(OrderItem::class, Products::class, 'seller_id', 'product_id');
    }

    /** Always return a valid commission rate (defaults to 0) */
    public function getCommission()
    {
        return $this->commission_rate ?? 0;
    }


    public function role()
    {
        // Return the seller role directly (not a relationship)
        return Role::where('slug', 'seller')->first();
    }

    public function permissions()
    {
        $role = $this->role();
        return $role ? $role->permissions : collect();
    }

    public function hasPermission(string $slug): bool
    {
        // If seller’s role has the permission, allow
        return $this->permissions()->contains('slug', $slug);
    }

    public function hasAnyPermission(array $slugs): bool
    {
        return $this->permissions()->whereIn('slug', $slugs)->isNotEmpty();
    }

}

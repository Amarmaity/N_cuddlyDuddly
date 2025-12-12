<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'is_approved',
        'approved_by',
        'approved_at',
        'commission_percent',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . uniqid();
            }
        });
    }

    // 🔗 Relationships

    // Product belongs to a seller
    public function seller()
    {
        return $this->belongsTo(Sellers::class, 'seller_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    // Product can have many images
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // Get primary image of the product
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id')->where('is_primary', 1);
    }


    // Product can have many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    // Product approved by admin
    public function approvedBy()
    {
        return $this->belongsTo(AdminUser::class, 'approved_by');
    }

    // 🔍 Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }

    public function categoryChain()
    {
        return $this->hasOne(ProductCategorySection::class, 'product_id');
    }

    public function categorySections()
    {
        return $this->hasMany(ProductCategorySection::class, 'product_id');
    }

    public function orders()
    {
        // Many-to-Many: products <-> orders via order_items
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCategoryGroup extends Model
{
    use HasFactory;

    protected $table = 'home_category_groups';

    protected $fillable = [
        'title',
        'slug',
        'display_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * A home category group has many items (if needed)
     */
    public function items()
    {
        return $this->hasMany(HomeCategoryGroup::class)
            ->orderBy('display_order');
    }

    /**
     * The master categories attached to this home category group
     */
    public function masterCategories()
    {
        return $this->belongsToMany(
            MasterCategory::class,                     // Related model
            'home_category_group_master_category',     // Pivot table
            'home_category_group_id',                  // Foreign key on pivot table for this model
            'master_category_id'                       // Foreign key on pivot table for related model
        )->withTimestamps();
    }
}

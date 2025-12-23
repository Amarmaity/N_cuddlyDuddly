<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'status'];

    public function masterCategories()
    {
        return $this->hasManyThrough(
            MasterCategory::class,
            MasterCategorySection::class,
            'department_id',        // FK on pivot
            'id',                   // PK on MasterCategory
            'id',                   // PK on Department
            'master_category_id'    // FK on pivot
        )->distinct();
    }

    public function masterCategorySections()
    {
        return $this->hasMany(MasterCategorySection::class);
    }

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionType extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function masterCategories()
    {
        return $this->belongsToMany(
            MasterCategory::class,
            'master_category_sections',
            'section_type_id',
            'master_category_id'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'master_category_sections',
            'section_type_id',
            'category_id'
        )->withPivot(['master_category_id', 'department_id'])->distinct();
    }
}

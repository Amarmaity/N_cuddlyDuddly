<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'image_url', 'status'];

    public function department()
    {
        return $this->hasOneThrough(
            Department::class,
            MasterCategorySection::class,
            'master_category_id',  // pivot FK
            'id',                  // Department PK
            'id',                  // MC PK
            'department_id'        // pivot FK
        );
    }


    public function sectionTypes()
    {
        return $this->hasManyThrough(
            SectionType::class,
            MasterCategorySection::class,
            'master_category_id',
            'id',
            'id',
            'section_type_id'
        )->distinct();
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'master_category_sections',
            'master_category_id',
            'category_id'
        )->withPivot(['section_type_id', 'department_id'])->distinct();
    }
}

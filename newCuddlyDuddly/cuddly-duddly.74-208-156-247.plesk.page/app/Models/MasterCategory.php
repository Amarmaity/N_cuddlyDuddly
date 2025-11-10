<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'image_url', 'status'];

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'master_category_sections',
            'master_category_id',
            'department_id'
        )->distinct();
    }

    public function sectionTypes()
    {
        return $this->belongsToMany(
            SectionType::class,
            'master_category_sections',
            'master_category_id',
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
        );
    }
}

<?php

namespace App\Services;

use App\Models\Department;
use App\Models\MasterCategorySection;


class CategoryTreeService
{
    public static function build(): array
    {
        $departments = Department::where('status', 1)->get();
        // dd($departments);
        return $departments->map(function ($dept) {
            
            $sections = MasterCategorySection::with([
                'masterCategory' => fn ($q) => $q->where('status', 1),
                'sectionType', // ✅ no status column here
                'category' => fn ($q) => $q->where('status', 1),
                ])
                ->whereIn('department_id', [$dept->id])
                // dd($sections->toSql());
                ->get();


            $masterCategories = $sections
                ->groupBy('master_category_id')
                ->map(function ($mcSections) {

                    $masterCategory = $mcSections->first()->masterCategory;
                    if (!$masterCategory) return null;

                    $sectionTypes = $mcSections
                        ->groupBy('section_type_id')
                        ->map(function ($stSections) {

                            $sectionType = $stSections->first()->sectionType;
                            if (!$sectionType) return null;

                            $categories = $stSections
                                ->pluck('category')
                                ->filter()
                                ->unique('id')
                                ->map(fn ($cat) => [
                                    'id' => $cat->id,
                                    'name' => $cat->name,
                                ])
                                ->values()
                                ->toArray();

                            return [
                                'id' => $sectionType->id,
                                'name' => $sectionType->name,
                                'categories' => $categories,
                            ];
                        })
                        ->filter()
                        ->values()
                        ->toArray();

                    return [
                        'id' => $masterCategory->id,
                        'name' => $masterCategory->name,
                        'section_types' => $sectionTypes,
                    ];
                })
                ->filter()
                ->values()
                ->toArray();

            return [
                'id' => $dept->id,
                'name' => $dept->name,
                'master_categories' => $masterCategories,
            ];
        })->toArray();
    }
}

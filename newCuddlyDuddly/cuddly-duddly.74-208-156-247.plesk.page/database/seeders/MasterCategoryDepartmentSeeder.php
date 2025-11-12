<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\MasterCategory;
use App\Models\MasterCategorySection;

class MasterCategoryDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $mapping = [
            'BOY FASHION' => 'Apparel',
            'GIRL FASHION' => 'Apparel',
            'FOOTWEAR' => 'Apparel',
            'TOYS' => 'Gear & Toys',
            'DIAPERING' => 'Bath & Diapering',
            'GEAR' => 'Gear & Toys',
            'FEEDING' => 'Nursing & Feeding',
            'BATH' => 'Bath & Diapering',
            'NURSERY' => 'Furniture',
            'MOMS' => "Women's Beauty & Care",
        ];

        foreach ($mapping as $masterName => $departmentName) {
            $department = Department::where('name', $departmentName)->first();
            $masterCategory = MasterCategory::where('name', $masterName)->first();

            if ($department && $masterCategory) {
                // find related section record
                $section = MasterCategorySection::where('master_category_id', $masterCategory->id)->first();

                if ($section) {
                    $section->department_id = $department->id;
                    $section->save();
                }
            }
        }

        $this->command->info('✅ Master category sections linked to departments successfully!');
    }
}

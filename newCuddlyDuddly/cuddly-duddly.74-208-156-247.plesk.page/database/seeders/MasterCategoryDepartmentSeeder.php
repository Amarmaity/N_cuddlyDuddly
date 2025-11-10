<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterCategory;
use App\Models\Department;

class MasterCategoryDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // Define mapping between master categories and departments
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
            $master = MasterCategory::where('name', $masterName)->first();

            if ($department && $master) {
                $master->department_id = $department->id;
                $master->save();
            }
        }

        $this->command->info('✅ Master categories linked to departments successfully!');
    }
}

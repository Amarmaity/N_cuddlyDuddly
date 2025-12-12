<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\MasterCategory;

class MasterCategoryDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Departments (as you requested)
        $departments = [
            'Strollers',
            'Car Seats',
            'Furniture',
            'Bedding',
            'Bath & Diapering',
            'Nursing & Feeding',
            'Safety & Wellness',
            'Apparel',
            'Gear & Toys',
            'Boutiques',
            "Women's Beauty & Care",
            'Birthday & Gifts',
            'Books & School Supplies',
            'Store & Preschools',
        ];

        foreach ($departments as $name) {
            Department::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name), 'status' => 1]
            );
        }

        // 2) Master categories (the list you provided)
        $masterCategories = [
            'BOY FASHION',
            'GIRL FASHION',
            'FOOTWEAR',
            'TOYS',
            'DIAPERING',
            'GEAR',
            'FEEDING',
            'BATH',
            'NURSERY',
            'MOMS',
            'HEALTH & SAFETY',
            'BOUTIQUES',
            "WOMEN'S BEAUTY & CARE",
            'BIRTHDAYS GIFTS',
            'BOOKS',
            'SCHOOL SUPPLIES',
            'HOME & LIVING',
            "CARTER'S",
            // add more master categories here if needed
        ];

        foreach ($masterCategories as $mcName) {
            MasterCategory::firstOrCreate(
                ['name' => $mcName],
                ['slug' => Str::slug($mcName), 'status' => 1]
            );
        }

        // 3) Mapping master category => department (adjust if you want different mapping)
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
            'HEALTH & SAFETY' => 'Safety & Wellness',
            'BOUTIQUES' => 'Boutiques',
            "WOMEN'S BEAUTY & CARE" => "Women's Beauty & Care",
            'BIRTHDAYS GIFTS' => 'Birthday & Gifts',
            'BOOKS' => 'Books & School Supplies',
            'SCHOOL SUPPLIES' => 'Books & School Supplies',
            'HOME & LIVING' => 'Store & Preschools', // fallback — change if you want
            "CARTER'S" => 'Boutiques', // fallback — change if you want
        ];

        // 4) Insert pivot rows (department ↔ master_category) into master_category_sections
        foreach ($mapping as $mcName => $deptName) {
            $dept = Department::where('name', $deptName)->first();
            $mc = MasterCategory::where('name', $mcName)->first();

            if (!$dept) {
                $this->command->warn("Department not found for mapping: {$deptName} (skipping mapping for {$mcName})");
                continue;
            }

            if (!$mc) {
                $this->command->warn("MasterCategory not found: {$mcName} (skipping)");
                continue;
            }

            // insert pivot row (will update if exists)
            DB::table('master_category_sections')->updateOrInsert(
                [
                    'master_category_id' => $mc->id,
                    'department_id' => $dept->id,
                    // section_type_id and category_id deliberately left out here (null)
                ],
                [
                    'master_category_id' => $mc->id,
                    'department_id' => $dept->id,
                    'section_type_id' => null,
                    'category_id' => null,
                ]
            );
        }

        $this->command->info('✅ Master categories and department mappings seeded successfully!');
    }
}

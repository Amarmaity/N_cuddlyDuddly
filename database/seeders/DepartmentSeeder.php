<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
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

        $this->command->info('✅ Departments seeded successfully!');
    }
}

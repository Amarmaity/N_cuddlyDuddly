<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomeCategoryGroup;
use Illuminate\Support\Facades\DB;

class HomeCategoryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // disable FK checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // first clear pivot table
        DB::table('home_category_group_master_category')->delete();

        // then clear main table
        DB::table('home_category_groups')->delete();

        // re-enable FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $groups = [
            [
                'title' => 'Pregnancy & Mom',
                'slug' => 'pregnancy-mom',
                'display_order' => 1,
                'master_category_ids' => [10, 9], // IDs of master categories
            ],
            [
                'title' => 'Infant & New Born Essentials',
                'slug' => 'infant-newborn-essentials',
                'display_order' => 2,
                'master_category_ids' => [11],
            ],
            [
                'title' => 'Baby Gear & Travels',
                'slug' => 'baby-gear-travels',
                'display_order' => 3,
                'master_category_ids' => [6, 4],
            ],
            [
                'title' => 'Fashion (0-10+ years)',
                'slug' => 'fashion-0-10-years',
                'display_order' => 4,
                'master_category_ids' => [1, 2],
            ],
            [
                'title' => 'Nursery & Room Decor',
                'slug' => 'nursery-room-decor',
                'display_order' => 5,
                'master_category_ids' => [17],
            ],
            [
                'title' => 'Toys, Books & Learning',
                'slug' => 'toys-books-learning',
                'display_order' => 6,
                'master_category_ids' => [18, 15, 12],
            ],
        ];

        foreach ($groups as $groupData) {
            // Create the Home Category Group
            $group = HomeCategoryGroup::create([
                'title' => $groupData['title'],
                'slug' => $groupData['slug'],
                'display_order' => $groupData['display_order'],
                'status' => 1,
            ]);

            // Attach master categories via pivot table
            if (!empty($groupData['master_category_ids'])) {
                $group->masterCategories()->attach($groupData['master_category_ids']);
            }
        }
    }
}

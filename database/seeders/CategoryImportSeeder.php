<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\MasterCategory;
use App\Models\SectionType;
use App\Models\Category;
use App\Models\MasterCategorySection;

class CategoryImportSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = base_path('database/seeders/FIRSTCRY PRODUCT CATEGORY LIST.xls');

        if (!file_exists($filePath)) {
            $this->command->error("❌ Excel file not found: {$filePath}");
            return;
        }

        $this->command->info("📘 Reading Excel file: {$filePath}");
        $spreadsheet = IOFactory::load($filePath);

        // ✅ Department mapping
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
            'HOME & LIVING' => 'Furniture',
            "CARTER'S" => 'Apparel',
        ];

        $totalInserted = 0;

        // ✅ Loop through each sheet
        foreach ($spreadsheet->getWorksheetIterator() as $sheet) {
            $masterCategoryName = trim($sheet->getTitle());
            if (!$masterCategoryName) continue;

            $this->command->info("➡ Master Category: {$masterCategoryName}");

            // Map department
            $departmentName = $mapping[$masterCategoryName] ?? 'Miscellaneous';

            $department = Department::firstOrCreate(
                ['name' => $departmentName],
                ['slug' => Str::slug($departmentName), 'status' => 1]
            );

            $masterCategory = MasterCategory::firstOrCreate(
                ['name' => $masterCategoryName],
                ['slug' => Str::slug($masterCategoryName), 'status' => 1]
            );

            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

            // ✅ Read column by column
            for ($col = 1; $col <= $highestColumnIndex; $col++) {
                $row = 1;

                while ($row <= $highestRow) {
                    $cell = $sheet->getCellByColumnAndRow($col, $row);
                    $value = trim((string)$cell->getValue());

                    if (!$value) {
                        $row++;
                        continue;
                    }

                    $style = $sheet->getStyle($cell->getCoordinate());
                    $font = $style->getFont();
                    $isBold = $font->getBold();
                    $isUpper = strtoupper($value) === $value;

                    // ✅ Detect Section Type (bold + uppercase)
                    if ($isBold && $isUpper && strlen($value) > 3) {
                        $sectionType = SectionType::firstOrCreate(
                            ['name' => $value],
                            ['slug' => Str::slug($value)]
                        );
                        $this->command->info("   🧩 Section Type: {$value}");

                        // ✅ Now read categories under this section type
                        $nextRow = $row + 1;
                        while ($nextRow <= $highestRow) {
                            $nextCell = $sheet->getCellByColumnAndRow($col, $nextRow);
                            $nextValue = trim((string)$nextCell->getValue());

                            if (!$nextValue) {
                                $nextRow++;
                                continue;
                            }

                            $nextStyle = $sheet->getStyle($nextCell->getCoordinate());
                            $nextFont = $nextStyle->getFont();
                            $nextIsBold = $nextFont->getBold();
                            $nextIsUpper = strtoupper($nextValue) === $nextValue;

                            // ✅ Stop when next section type starts
                            if ($nextIsBold && $nextIsUpper && strlen($nextValue) > 3) {
                                break;
                            }

                            if (isset($sectionType)) {
                                $category = Category::firstOrCreate(
                                    ['name' => $nextValue],
                                    ['slug' => Str::slug($nextValue), 'status' => 1]
                                );

                                MasterCategorySection::firstOrCreate([
                                    'department_id' => $department->id,
                                    'master_category_id' => $masterCategory->id,
                                    'section_type_id' => $sectionType->id,
                                    'category_id' => $category->id,
                                ]);

                                $this->command->line("      📦 Category: {$nextValue}");
                                $totalInserted++;
                            }

                            $nextRow++;
                        }

                        // Jump to next section
                        $row = $nextRow;
                        continue;
                    }

                    $row++;
                }
            }
        }

        // ✅ Summary for verification
        $this->command->info("\n🧾 Summary for BOY FASHION & GIRL FASHION:\n");

        $summaryCategories = ['BOY FASHION', 'GIRL FASHION'];

        foreach ($summaryCategories as $masterCatName) {
            $master = MasterCategory::where('name', $masterCatName)->first();

            if (!$master) {
                $this->command->warn("⚠ No data found for {$masterCatName}");
                continue;
            }

            $this->command->info("➡ Master Category: {$masterCatName}");

            $sectionRelations = MasterCategorySection::where('master_category_id', $master->id)
                ->with(['sectionType', 'category'])
                ->get()
                ->groupBy('section_type_id');

            foreach ($sectionRelations as $sectionTypeId => $records) {
                $sectionName = optional($records->first()->sectionType)->name ?? 'Unknown Section';
                $this->command->line("   🧩 Section Type: {$sectionName}");

                foreach ($records as $rel) {
                    $catName = optional($rel->category)->name;
                    $this->command->line("      📦 {$catName}");
                }
            }
        }

        $this->command->info("✅ Import completed! Total categories inserted: {$totalInserted}");
    }
}

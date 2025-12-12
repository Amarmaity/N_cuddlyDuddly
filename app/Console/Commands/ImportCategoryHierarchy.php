<?php 
    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use App\Models\MasterCategory;
    use App\Models\SectionType;
    use App\Models\Category;
    use App\Models\Department;
    use Illuminate\Support\Str;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use Illuminate\Support\Facades\DB;

    class ImportCategoryHierarchy extends Command
    {
        protected $signature = 'import:sections {file}';
        protected $description = 'Import Departments, Master Categories, Section Types, and Categories from Excel';

        public function handle()
        {
            $file = $this->argument('file');

            if (!file_exists($file)) {
                $this->error("❌ File not found: $file");
                return;
            }

            $this->info("📥 Reading Excel file: $file");

            // Load spreadsheet
            $spreadsheet = IOFactory::load($file);
            $sheetNames = $spreadsheet->getSheetNames(); // These are your master categories

            foreach ($sheetNames as $sheetName) {
                $sheetName = trim($sheetName);
                if (!$sheetName) continue;

                // Determine department
                $departmentName = $this->getDepartmentFromMaster($sheetName);
                $department = Department::firstOrCreate(
                    ['name' => $departmentName],
                    ['slug' => Str::slug($departmentName), 'status' => 1]
                );

                $masterCategory = MasterCategory::firstOrCreate(
                    ['name' => $sheetName],
                    ['slug' => Str::slug($sheetName), 'status' => 1, 'department_id' => $department->id]
                );

                $this->info("➡ Master Category: $sheetName (Department: $departmentName)");

                $sheet = $spreadsheet->getSheetByName($sheetName);
                $rows = $sheet->toArray();

                $currentSectionType = null;

                foreach ($rows as $rowIndex => $row) {
                    foreach ($row as $colIndex => $cell) {
                        $cellString = trim((string) $cell); // Force string and trim

                        if (!$cellString) continue; // Skip empty cells

                        // Detect section type: number followed by dot or parenthesis
                        if (preg_match('/^\d+[\.\)]\s*(.+)$/', $cellString, $matches)) {
                            $sectionName = trim($matches[1]);

                            // Create or get SectionType
                            $currentSectionType = SectionType::firstOrCreate(
                                ['name' => $sectionName],
                                ['slug' => Str::slug($sectionName)]
                            );

                            $this->info("  ➡ Section Type: $sectionName");
                            continue; // Go to next cell
                        }

                        // Skip categories if no section type found yet
                        if (!$currentSectionType) continue;

                        // Create category
                        $category = Category::firstOrCreate(
                            ['name' => $cellString],
                            ['slug' => Str::slug($cellString), 'status' => 1]
                        );

                        // Insert into pivot table
                        DB::table('master_category_sections')->updateOrInsert([
                            'department_id' => $department->id,
                            'master_category_id' => $masterCategory->id,
                            'section_type_id' => $currentSectionType->id,
                            'category_id' => $category->id,
                        ]);

                        $this->info("    ➡ Category: $cellString");
                    }
                }
            }

            $this->info("✅ Import completed!");
        }

        private function getDepartmentFromMaster($masterName)
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
                'HEALTH & SAFETY' => 'Safety & Wellness',
                'BOUTIQUES' => 'Boutiques',
                "WOMEN'S BEAUTY & CARE" => "Women's Beauty & Care",
                'BIRTHDAYS GIFTS' => 'Birthday & Gifts',
                'BOOKS' => 'Books & School Supplies',
                'SCHOOL SUPPLIES' => 'Books & School Supplies',
                'HOME & LIVING' => 'Furniture',
                "CARTER'S" => 'Apparel',
            ];

            return $mapping[$masterName] ?? 'Miscellaneous';
        }
    }

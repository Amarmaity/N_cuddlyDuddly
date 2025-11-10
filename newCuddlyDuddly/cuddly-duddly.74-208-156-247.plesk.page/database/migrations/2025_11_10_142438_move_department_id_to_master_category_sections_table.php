<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('master_category_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('master_category_sections', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('master_category_id');
                $table->foreign('department_id')
                    ->references('id')
                    ->on('departments')
                    ->onDelete('set null');
            }
        });

        // 2️⃣ Copy data from master_categories.department_id (if exists)
        if (Schema::hasColumn('master_categories', 'department_id')) {
            DB::statement("
                UPDATE master_category_sections mcs
                JOIN master_categories mc ON mc.id = mcs.master_category_id
                SET mcs.department_id = mc.department_id
                WHERE mc.department_id IS NOT NULL
            ");
        }

        // 3️⃣ (Optional) Drop department_id from master_categories
        Schema::table('master_categories', function (Blueprint $table) {
            if (Schema::hasColumn('master_categories', 'department_id')) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_category_sections', function (Blueprint $table) {
            Schema::table('master_categories', function (Blueprint $table) {
                if (!Schema::hasColumn('master_categories', 'department_id')) {
                    $table->unsignedBigInteger('department_id')->nullable()->after('id');
                    $table->foreign('department_id')
                        ->references('id')
                        ->on('departments')
                        ->onDelete('set null');
                }
            });

            // 2️⃣ Restore department_id values (reverse copy)
            DB::statement("
            UPDATE master_categories mc
            JOIN master_category_sections mcs ON mc.id = mcs.master_category_id
            SET mc.department_id = mcs.department_id
            WHERE mcs.department_id IS NOT NULL
        ");

            // 3️⃣ Drop department_id from master_category_sections
            Schema::table('master_category_sections', function (Blueprint $table) {
                if (Schema::hasColumn('master_category_sections', 'department_id')) {
                    $table->dropForeign(['department_id']);
                    $table->dropColumn('department_id');
                }
            });
        });
    }
};

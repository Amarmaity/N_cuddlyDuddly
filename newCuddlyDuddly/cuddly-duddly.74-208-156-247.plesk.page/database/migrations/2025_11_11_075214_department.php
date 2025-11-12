<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1️⃣ Create departments table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        // 2️⃣ Add department_id to master_category_sections table
        if (Schema::hasTable('master_category_sections')) {
            Schema::table('master_category_sections', function (Blueprint $table) {
                $table->foreignId('department_id')
                    ->nullable()
                    ->constrained('departments')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the foreign key + column safely
        if (Schema::hasTable('master_category_sections') &&
            Schema::hasColumn('master_category_sections', 'department_id')) {

            Schema::table('master_category_sections', function (Blueprint $table) {
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            });
        }

        // Drop departments table
        Schema::dropIfExists('departments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_category_group_master_category', function (Blueprint $table) {
            $table->id();

            // Match existing table types
            $table->unsignedBigInteger('home_category_group_id'); // matches home_category_groups.id (bigint)
            $table->integer('master_category_id');       // matches master_categories.id (int(11))

            $table->timestamps();

            // Foreign keys
            $table->foreign('home_category_group_id', 'hcg_mc_group_fk')
                  ->references('id')
                  ->on('home_category_groups')
                  ->onDelete('cascade');

            $table->foreign('master_category_id', 'hcg_mc_master_fk')
                  ->references('id')
                  ->on('master_categories')
                  ->onDelete('cascade');

            // Unique to prevent duplicates
            $table->unique(['home_category_group_id', 'master_category_id'], 'hcg_mc_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_category_group_master_category');
    }
};

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
        Schema::create('landing_conponents', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->string('sub_heading')->nullable();
            $table->string('story')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('banner_image2')->nullable();
            $table->string('shop_by_category_image1')->nullable();
            $table->string('shop_by_category_image2')->nullable();
            $table->string('shop_by_category_image3')->nullable();
            $table->string('shop_by_category_image4')->nullable();
            $table->string('shop_by_category_image5')->nullable();
            $table->string('shop_by_category_image6')->nullable();
            $table->string('shop_by_category_image7')->nullable();
            $table->string('shop_by_category_image8')->nullable();
            $table->string('shop_by_category_image9')->nullable();
            $table->string('shop_by_category_image10')->nullable();
            $table->string('shop_by_category_image11')->nullable();
            $table->string('shop_by_category_image12')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->string('image6')->nullable();
            $table->string('image7')->nullable();
            $table->string('image8')->nullable();
            $table->string('image9')->nullable();
            $table->string('image10')->nullable();
            $table->string('image11')->nullable();
            $table->string('image12')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_conponents');
    }
};

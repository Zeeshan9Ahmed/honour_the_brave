<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('category_name')->nullable();
            $table->enum('category_type', ['business', 'normal'])->nullable();
            $table->timestamps();
        });

        foreach (range(1, 10) as $category) {
            DB::table('categories')->insert([
                'image' => null,
                'category_name' => "Category $category",
                'category_type' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach (['Resturants', 'Real Estate', 'Automobile'] as $category) {
            DB::table('categories')->insert([
                'image' => null,
                'category_name' => $category,
                'category_type' => 'business',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};

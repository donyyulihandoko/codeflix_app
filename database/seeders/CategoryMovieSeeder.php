<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Movie;

class CategoryMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('category_movie')->truncate();

        $categoryIds = Category::query()->pluck('id')->toArray();
        $movieIds = Movie::query()->pluck('id')->toArray();

        foreach ($movieIds as $movieId) {
            $randomCategoryId = array_rand($categoryIds, rand(1, 3));
            $randomCategoryId = (array) $randomCategoryId;

            foreach ($randomCategoryId as $categoryId) {
                DB::table('category_movie')->insert([
                    'category_id' => $categoryIds[$categoryId],
                    'movie_id' => $movieId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }


        Schema::enableForeignKeyConstraints();
    }
}

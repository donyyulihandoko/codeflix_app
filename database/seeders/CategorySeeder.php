<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Action',
            'Adventure',
            'Animation',
            'Comedy',
            'Crime',
            'Documentary',
            'Drama',
            'Fantasy',
            'Horror',
            'Musical',
            'Mystery',
            'Romance',
            'Science Fiction',
            'Thriller',
            'Western',
        ];

        foreach ($categories as $category) {
            Category::query()->create([
                'title' => $category,
                'slug' => Str::of($category)->slug('-'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

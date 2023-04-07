<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void //todo add images
    {
        $tags = ['Vegetarian', 'Soy', 'Gluten', 'Milk', 'Eggs', 'Fish', 'Shellfish', 'Nuts', 'Spicy 1', 'Spicy 2', 'Spicy 3'];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}

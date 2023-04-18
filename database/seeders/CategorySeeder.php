<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Appetizers',
            'Soups',
            'Rice and Noodles',
            'Meat and Poultry',
            'Seafood',
            'Vegetables',
            'Desserts'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Image;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
								/*placeholder*/
			['name' => 'Placeholder', 'image' => 'placeholder.jpg'],
								/*tags*/
            ['name' => 'Crustacean', 'image' => 'tags/crustacean.png'],
            ['name' => 'Eggs', 'image' => 'tags/eggs.png'],
            ['name' => 'Fish', 'image' => 'tags/fish.png'],
            ['name' => 'Gluten', 'image' => 'tags/gluten.png'],
            ['name' => 'Milk', 'image' => 'tags/milk.png'],
            ['name' => 'Nuts', 'image' => 'tags/nuts.png'],
            ['name' => 'Sesame', 'image' => 'tags/sesame.png'],
            ['name' => 'Shellfish', 'image' => 'tags/shellfish.png'],
								/*menus*/
			['name' => 'Menu', 'image' => 'public/1.jpg'],
			['name' => 'Menu', 'image' => 'public/2.jpg'],
			['name' => 'Menu', 'image' => 'public/3.jpg'],
			['name' => 'Menu', 'image' => 'public/4.jpg'],
			['name' => 'Menu', 'image' => 'public/5.jpg'],
			['name' => 'Menu', 'image' => 'public/6.jpg'],
			['name' => 'Menu', 'image' => 'public/7.jpg'],
			['name' => 'Menu', 'image' => 'public/8.jpg'],
			['name' => 'Menu', 'image' => 'public/9.jpg'],
			['name' => 'Menu', 'image' => 'public/10.jpg'],
			['name' => 'Menu', 'image' => 'public/11.jpg'],
			['name' => 'Menu', 'image' => 'public/12.jpg'],
			
        ];

        foreach ($images as $image) {
            Image::create($image);
        }
    }
}

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
	public function run(): void
    {
        $tags = [
			['name' => 'Crustacean', 'image_id' => 2],
			['name' => 'Eggs', 'image_id' => 3],
			['name' => 'Fish', 'image_id' => 4],
			['name' => 'Gluten', 'image_id' => 5],
			['name' => 'Milk', 'image_id' => 6],
			['name' => 'Nuts', 'image_id' => 7],
			['name' => 'Sesame', 'image_id' => 8],
			['name' => 'Shellfish', 'image_id' => 9],
		];
        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}

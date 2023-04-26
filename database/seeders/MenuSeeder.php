<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Tag;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = Menu::factory()->count(40)->create();
		
		//6 recommended
		$menus->random(6)->each(function ($menu) {
			$menu->update(['recommended' => true]);
		});
		
		$tagIds = Tag::pluck('id');

        foreach ($menus as $menu) {
            $menu->tags()->attach($tagIds->random(rand(0, 4)));
        }
    }
}

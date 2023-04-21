<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class FrontController extends Controller
{
	public function landing()
	{
		return view('landing');
	}
	
    public function menu()
    {
        $categories = Category::with('menus')->get();
		$recommendedMenus = Menu::inRandomOrder()->take(6)->get();
		
        return view('menu', ['categories' => $categories,
							 'recommendedMenus' => $recommendedMenus,
							]);
    }
	
	public function contact()
	{
		return view('contact');
	}
}

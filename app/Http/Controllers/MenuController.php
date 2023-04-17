<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMenuRequest;
use App\Models\Menu;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

/*
	TODO refactor headers to the model
*/

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headers = ['name', 'description', 'price', 'image_id'];
		$menus = Menu::select('id', 'name', 'description', 'price', 'image_id')->paginate(10);
		$createUrl = route('admin.menus.create');
		$editUrl = route('admin.menus.edit', ['menu' => '__id__']);
		$deleteUrl = route('admin.menus.destroy', ['menu' => '__id__']);


		return view('dashboard.layouts.index', ['title' => 'Menus',
												'data' => $menus,
												'headers' => $headers,
												'createUrl' => $createUrl,
												'editUrl' => $editUrl,
												'deleteUrl' => $deleteUrl,
											   ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$images = Image::all();
		$attributes = ['name', 'description', 'price', 'image_id'];
        return view('dashboard.layouts.create', ['attributes' => $attributes,
												 'resourceType' => 'menu',
												 'nextRoute' => 'App\Http\Controllers\MenuController@store',
												 'returnRoute' => '/admin/menus',
												 'images' => $images,
											  ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {

		$menu = new Menu;
		$data = $request->validated();
		
		// Handle file upload
		if ($request->hasFile('image')) {
			$movedImage = $request->image->move(public_path('images/public'), $request->image->getClientOriginalName());
			
			$image = Image::create([
				'name' => $request->image->getClientOriginalName(),
				'image' => 'public/'.$request->image->getClientOriginalName()
			]);
			$image->save();
			$menu->image()->associate($image);
			
		} else if (!empty($request->input('selected-image'))) {
			// Use the selected image
			$image = Image::find($request->input('selected-image'));
			$menu->image()->associate($image);
    	}
		
		$menu->fill($request->except('image'));
		$menu->save();

		return redirect()->route('admin.menus.show', ['menu' => $menu->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::find($id);
		$images = Image::all();
    	return view('dashboard.layouts.show', ['resource' => $menu,
											   'resourceType' => 'menu',
											   'nextRoute' => 'App\Http\Controllers\MenuController@update', //?
											   'returnRoute' => '/admin/menus',
											   'images' => $images,
											   'disabled' => '1'
											  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
		$menu = Menu::find($id);
		$images = Image::all();
    	return view('dashboard.layouts.show', ['resource' => $menu,
											   'resourceType' => 'menu',
											   'nextRoute' => 'App\Http\Controllers\MenuController@update',
											   'returnRoute' => '/admin/menus',
											   'images' => $images,
											  ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMenuRequest $request, String $id)
    {
		$data = $request->validated();
		$menu = Menu::find($id);

		// Handle file upload
		if ($request->hasFile('image')) {
			// Move the uploaded file
			$movedImage = $request->image->move(public_path('images/public'), $request->image->getClientOriginalName());

			// Create a new image record in the images table
			$image = Image::create([
				'name' => $request->image->getClientOriginalName(),
				'image' => 'public/'.$request->image->getClientOriginalName()
			]);
			$image->save();
			// Associate the menu item with the image
			$menu->image()->associate($image);
		} else {
			// Use the selected image
			$image = Image::find($request->input('selected-image'));
			$menu->image()->associate($image);
		}

		$menu->fill($request->except('image'));
		$menu->save();
		return redirect()->route('admin.menus.show', ['menu' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
		$menu = Menu::findOrFail($id);
		$menu->delete();
		session()->flash('success', trans('headers.deletedSuccess'));
		return redirect()->route('admin.menus.index');
    }
}

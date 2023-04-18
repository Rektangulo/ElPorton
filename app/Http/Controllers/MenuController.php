<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMenuRequest;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;

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
		session()->put('previousUrl', request()->fullUrl());

		return view('dashboard.layouts.index', ['title' => 'Menus',
												'data' => $menus,
												'headers' => $headers,
											   ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$images = Image::all();
		$tags = Tag::all();
		$attributes = ['name', 'description', 'price', 'image_id'];
        return view('dashboard.layouts.create', ['attributes' => $attributes,
												 'resourceType' => 'menu',
												 'nextRoute' => 'App\Http\Controllers\MenuController@store',
												 'images' => $images,
												 'showTags' => '1',
                                               	 'tags' => $tags,
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
			
			$image = ImageUploadService::store($request);
			if ($image instanceof RedirectResponse) {
				return $image;
			}
			$menu->image()->associate($image);
			
		} else if (!empty($request->input('selected-image'))) {
			// Use the selected image
			$image = Image::find($request->input('selected-image'));
			$menu->image()->associate($image);
    	}
		
		$menu->fill($request->except('image'));
		$menu->save();
		
		// Update tags
        $tags = $request->input('tags', []);
        $menu->tags()->sync($tags);

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
											   'images' => $images,
											   'disabled' => '1',
											   'showTags' => '1',
											  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
		$menu = Menu::find($id);
		$images = Image::all();
		$tags = Tag::all();
    	return view('dashboard.layouts.show', ['resource' => $menu,
											   'resourceType' => 'menu',
											   'nextRoute' => 'App\Http\Controllers\MenuController@update',
											   'images' => $images,
											   'showTags' => 1,
											   'tags' => $tags,
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

			$image = ImageUploadService::store($request);
			// Check if the result is an error response
			if ($image instanceof RedirectResponse) {
				return $image;
			}
			// Associate the menu item with the image
			$menu->image()->associate($image);
		} else {
			// Use the selected image
			$image = Image::find($request->input('selected-image'));
			$menu->image()->associate($image);
		}
		// Update tags
		$tags = $request->input('tags', []);
		$menu->tags()->sync($tags);
		
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

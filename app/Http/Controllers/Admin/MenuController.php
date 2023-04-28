<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreMenuRequest;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

/*
	TODO refactor headers to the model
*/

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
	public function index(Request $request)
	{
		$headers = ['name', 'description', 'price', 'image_id', 'recommended'];
		$search = $request->input('search');
		$menus = Menu::select('id', 'name', 'description', 'price', 'image_id', 'recommended')->where('name', 'like', '%' . $search . '%')->paginate(10);
		session()->put('previousUrl', request()->fullUrl());

		return view('admin.index', ['title' => 'Menus',
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
		$attributes = ['name', 'description', 'price', 'image_id', 'category_id', 'recommended'];
        return view('admin.create', ['attributes' => $attributes,
												 'resourceType' => 'menu',
												 'nextRoute' => 'App\Http\Controllers\Admin\MenuController@store',
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
		
		if ($request->has('recommended')) {
			$menu->recommended = true;
		} else {
			$menu->recommended = false;
		}
		$menu->fill($request->except(['image','recommended']));
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
    	return view('admin.show', ['resource' => $menu,
											   'resourceType' => 'menu',
											   'nextRoute' => 'App\Http\Controllers\Admin\MenuController@update', //?
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
    	return view('admin.show', ['resource' => $menu,
											   'resourceType' => 'menu',
											   'nextRoute' => 'App\Http\Controllers\Admin\MenuController@update',
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
		//$data = $request->validated();
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
		
		if ($request->has('recommended')) {
			$menu->recommended = true;
		} else {
			$menu->recommended = false;
		}
		
		$menu->fill($request->except(['image','recommended']));
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
		session()->flash('success', __('admin.deletedSuccess'));
		return redirect()->back();
    }
}

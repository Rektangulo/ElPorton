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

class MenuController extends Controller
{
	
	private static $menuFields = ['name', 'description', 'price', 'image_id', 'category_id', 'recommended'];
	private static $resourceType = "menu";
	
	private function handleImageUpload(Request $request, Menu $menu)
	{
		// Handle file upload
		if ($request->hasFile('image')) {
			$image = ImageUploadService::store($request);
			if ($image instanceof RedirectResponse) {
				return $image;
			}
			$menu->image()->associate($image);
		} elseif (!empty($request->input('selected-image'))) {
			// Use the selected image
			$image = Image::find($request->input('selected-image'));
			$menu->image()->associate($image);
		}
	}
	
    /**
     * Display a listing of the resource.
     */
	public function index(Request $request)
	{
		$menus = Menu::search($request->input('search'))->paginate(10);
		session()->put('previousUrl', request()->fullUrl());

		return view('admin.index', [
			'title' => 'Menus',
			'data' => $menus,
			'headers' => self::$menuFields,
		]);
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create', [
			'attributes' => self::$menuFields,
			'resourceType' => self::$resourceType,
			'nextRoute' => 'App\Http\Controllers\Admin\MenuController@store',
			'showTags' => '1',
		  ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
		$menu = new Menu;
		
		// Handle file upload
		$imageUploadResult = $this->handleImageUpload($request, $menu);
		if ($imageUploadResult instanceof RedirectResponse) {
			return $imageUploadResult;
		}
		
		$menu->fill($request->except(['image','recommended']));
		$menu->recommended = $request->has('recommended');
		$menu->save();
        $menu->updateTags($request->input('tags', []));

		return redirect()->route('admin.menus.show', ['menu' => $menu]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
    	return view('admin.show', [
			'resource' => $menu,
			'resourceType' => self::$resourceType,
			'nextRoute' => 'App\Http\Controllers\Admin\MenuController@update', //?
			'disabled' => '1',
			'showTags' => '1',
		  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
    	return view('admin.show', [
			'resource' => $menu,
			'resourceType' => self::$resourceType,
			'nextRoute' => 'App\Http\Controllers\Admin\MenuController@update',
			'showTags' => '1',
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMenuRequest $request, Menu $menu)
    {
		// Handle file upload
		$imageUploadResult = $this->handleImageUpload($request, $menu);
		if ($imageUploadResult instanceof RedirectResponse) {
			return $imageUploadResult;
		}
		
		$menu->fill($request->except(['image','recommended']));
		$menu->recommended = $request->has('recommended');
		$menu->save();
		$menu->updateTags($request->input('tags', []));
		
		return redirect()->route('admin.menus.show', ['menu' => $menu]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
		$menu->delete();
		session()->flash('success', __('admin.deletedSuccess'));
		return redirect()->back();
    }
}

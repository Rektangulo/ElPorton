<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMenuRequest;
use App\Models\Menu;
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
        $headers = ['name', 'description', 'price'];
		$menus = Menu::select('id', 'name', 'description', 'price')->paginate(10);
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
		$attributes = ['name', 'description', 'price', 'image'];
        return view('dashboard.layouts.create', ['attributes' => $attributes,
												 'resourceType' => 'menu',
												 'nextRoute' => 'App\Http\Controllers\MenuController@store',
												 'returnRoute' => '/admin/menus'
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
			$menu->image = 'public/'.$request->image->getClientOriginalName();
		} else if (!empty($request->input('selected-image'))) {
			// Use the selected image
			$menu->image = 'public/'.$request->input('selected-image');
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
    	return view('dashboard.layouts.show', ['resource' => $menu,
											   'resourceType' => 'menu',
											   'nextRoute' => 'App\Http\Controllers\MenuController@update', //?
											   'returnRoute' => '/admin/menus',
											   'disabled' => '1'
											  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
		$menu = Menu::find($id);
    	return view('dashboard.layouts.show', ['resource' => $menu,
											   'resourceType' => 'menu',
											   'nextRoute' => 'App\Http\Controllers\MenuController@update',
											   'returnRoute' => '/admin/menus'
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
			$movedImage = $request->image->move(public_path('images/public'), $request->image->getClientOriginalName());
			$menu->image = 'public/'.$request->image->getClientOriginalName();
		} else {
			// Use the selected image
			$menu->image = 'public/'.$request->input('selected-image');
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

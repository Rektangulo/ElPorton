<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $headers = ['name'];
		$search = $request->input('search');
		$categories = Category::select('id', 'name')->where('name', 'like', '%' . $search . '%')->paginate(10);
		session()->put('previousUrl', request()->fullUrl());

		return view('admin.index', ['title' => 'Categories',
												'data' => $categories,
												'headers' => $headers,
											   ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$attributes = ['name'];
        return view('admin.create', ['attributes' => $attributes,
												 'resourceType' => 'category',
												 'nextRoute' => 'App\Http\Controllers\Admin\CategoryController@store',
											  ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category;
		$category->fill($request->validated());
		$category->save();

		return redirect()->route('admin.categories.show', ['category' => $category]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
    	return view('admin.show', ['resource' => $category,
											   'resourceType' => 'category',
											   'nextRoute' => 'App\Http\Controllers\Admin\CategoryController@update',
											   'disabled' => '1'
											  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
    	return view('admin.show', ['resource' => $category,
											   'resourceType' => 'category',
											   'nextRoute' => 'App\Http\Controllers\Admin\CategoryController@update',
											  ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
		$category->fill($request->validated());
		$category->save();
		return redirect()->route('admin.categories.show', ['category' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
		session()->flash('success', __('admin.deletedSuccess'));
		return redirect()->route('admin.categories.index');
    }
}

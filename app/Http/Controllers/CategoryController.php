<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headers = ['name'];
		$categories = Category::select('id', 'name')->paginate(10);
		session()->put('previousUrl', request()->fullUrl());

		return view('dashboard.layouts.index', ['title' => 'Categories',
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
        return view('dashboard.layouts.create', ['attributes' => $attributes,
												 'resourceType' => 'category',
												 'nextRoute' => 'App\Http\Controllers\CategoryController@store',
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
    	return view('dashboard.layouts.show', ['resource' => $category,
											   'resourceType' => 'category',
											   'nextRoute' => 'App\Http\Controllers\CategoryController@update',
											   'disabled' => '1'
											  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
    	return view('dashboard.layouts.show', ['resource' => $category,
											   'resourceType' => 'category',
											   'nextRoute' => 'App\Http\Controllers\CategoryController@update',
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
		session()->flash('success', trans('headers.deletedSuccess'));
		return redirect()->route('admin.categories.index');
    }
}

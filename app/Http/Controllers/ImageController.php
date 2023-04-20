<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\ImageUpdateRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $headers = ['name', 'image'];
		$search = $request->input('search');
		$images = Image::select('id', 'name', 'image')->where('name', 'like', '%' . $search . '%')->paginate(10);
		session()->put('previousUrl', request()->fullUrl());

		return view('dashboard.layouts.index', ['title' => 'Images',
												'data' => $images,
												'headers' => $headers,
											   ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$attributes = ['name', 'image_id'];
        return view('dashboard.layouts.create', ['attributes' => $attributes,
												 'resourceType' => 'menu',
												 'nextRoute' => 'App\Http\Controllers\ImageController@store',
											  ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageUploadRequest $request)
    {
		$image = ImageUploadService::store($request);
		if ($image instanceof RedirectResponse) {
				return $image;
			}
		return redirect()->route('admin.images.show', ['image' => $image->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $image = Image::find($id);
    	return view('dashboard.layouts.show', ['resource' => $image,
											   'resourceType' => 'image',
											   'nextRoute' => 'App\Http\Controllers\ImageController@update', //?
											   'disabled' => '1'
											  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $image = Image::find($id);
    	return view('dashboard.layouts.show', ['resource' => $image,
											   'resourceType' => 'image',
											   'nextRoute' => 'App\Http\Controllers\ImageController@update',
											  ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImageUpdateRequest $request, Image $image)
    {
        $validated = $request->validated();
        $image->name = $validated['name'];
        $image->save();
		return redirect()->route('admin.images.show', ['image' => $image->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
		$path = public_path('images/' . $image->image);
		File::delete($path);
        $image->delete();
		session()->flash('success', trans('headers.deletedSuccess'));
		return redirect()->route('admin.images.index');
    }
}

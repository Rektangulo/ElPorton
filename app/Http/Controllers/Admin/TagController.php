<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Models\Tag;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $headers = ['name', 'image_id'];
		$search = $request->input('search');
		$tags = Tag::select('id', 'name', 'image_id')->where('name', 'like', '%' . $search . '%')->paginate(10);
		session()->put('previousUrl', request()->fullUrl());

		return view('admin.index', ['title' => 'Tags',
												'data' => $tags,
												'headers' => $headers,
											   ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $images = Image::all();
		$attributes = ['name', 'image_id'];
        return view('admin.create', ['attributes' => $attributes,
												 'resourceType' => 'tag',
												 'nextRoute' => 'App\Http\Controllers\Admin\TagController@store',
												 'images' => $images,
											  ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $tag = new Tag;
		$data = $request->validated();
		
		// Handle file upload
		if ($request->hasFile('image')) {
			
			$image = ImageUploadService::store($request);
			if ($image instanceof RedirectResponse) {
				return $image;
			}
			$tag->image()->associate($image);
			
		} else if (!empty($request->input('selected-image'))) {
			// Use the selected image
			$image = Image::find($request->input('selected-image'));
			$tag->image()->associate($image);
    	}
		
		$tag->fill($request->except('image'));
		$tag->save();

		return redirect()->route('admin.tags.show', ['tag' => $tag]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
		$images = Image::all();
    	return view('admin.show', ['resource' => $tag,
											   'resourceType' => 'tag',
											   'nextRoute' => 'App\Http\Controllers\Admin\TagController@update', //?
											   'images' => $images,
											   'disabled' => '1'
											  ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
		$images = Image::all();
    	return view('admin.show', ['resource' => $tag,
											   'resourceType' => 'tag',
											   'nextRoute' => 'App\Http\Controllers\Admin\TagController@update',
											   'images' => $images,
											  ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTagRequest $request, Tag $tag)
    {
        $data = $request->validated();

		// Handle file upload
		if ($request->hasFile('image')) {

			$image = ImageUploadService::store($request);
			if ($image instanceof RedirectResponse) {
				return $image;
			}
			
			$tag->image()->associate($image);
		} else {
			$image = Image::find($request->input('selected-image'));
			$tag->image()->associate($image);
		}

		$tag->fill($request->except('image'));
		$tag->save();
		return redirect()->route('admin.tags.show', ['tag' => $tag]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
		$tag->delete();
		session()->flash('success', __('admin.deletedSuccess'));
		return redirect()->route('admin.tags.index');
    }
}

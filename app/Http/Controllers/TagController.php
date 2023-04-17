<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headers = ['name', 'image_id'];
		$tags = Tag::select('id', 'name', 'image_id')->paginate(10);


		return view('dashboard.layouts.index', ['title' => 'Tags',
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
        return view('dashboard.layouts.create', ['attributes' => $attributes,
												 'resourceType' => 'tag',
												 'nextRoute' => 'App\Http\Controllers\TagController@store',
												 'returnRoute' => '/admin/tags',
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
    	return view('dashboard.layouts.show', ['resource' => $tag,
											   'resourceType' => 'tag',
											   'nextRoute' => 'App\Http\Controllers\TagController@update', //?
											   'returnRoute' => '/admin/tags',
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
    	return view('dashboard.layouts.show', ['resource' => $tag,
											   'resourceType' => 'tag',
											   'nextRoute' => 'App\Http\Controllers\TagController@update',
											   'returnRoute' => '/admin/tags',
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
		session()->flash('success', trans('headers.deletedSuccess'));
		return redirect()->route('admin.tags.index');
    }
}

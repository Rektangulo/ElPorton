<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\ImageUpdateRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $headers = ['name', 'image'];
		$images = Image::select('id', 'name', 'image')->paginate(10);


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
												 'returnRoute' => '/admin/images',
											  ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageUploadRequest $request)
    {
		$data = $request->validated();
		
		/*the request validation doesnt work, the images shouldnt be managed like this*/
		$existingImage = Image::where('image', 'public/'.$request->image->getClientOriginalName())->first();

        if ($existingImage) {
            return back()->withErrors(['image' => 'An image with this name already exists.']);
        }
		
		$request->image->move(public_path('images/public'), $request->image->getClientOriginalName());
		$image = Image::create([
				'name' => $data["name"],
				'image' => 'public/'.$request->image->getClientOriginalName()
			]);
        $image->save();

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
											   'returnRoute' => '/admin/images',
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
											   'returnRoute' => '/admin/images',
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

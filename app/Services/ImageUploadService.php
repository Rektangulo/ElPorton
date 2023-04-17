<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageUploadService
{
    public static function store(Request $request)
    {
		// Validate the request data
		$rules = [
            'name' => 'required|string',
            'image' => 'required|image|max:2048'
        ];

        $validatedData = $request->validate($rules);

        // Check if an image with the same name already exists
        $existingImage = Image::where('image', 'public/'.$request->image->getClientOriginalName())->first();

        if ($existingImage) {
            return back()->withErrors(['image' => 'An image with this name already exists.']);
        }

        // Move the uploaded image to the public/images directory
        $request->image->move(public_path('images/public'), $request->image->getClientOriginalName());

        // Create a new Image record in the database
        $image = Image::create([
            'name' => $validatedData["name"],
            'image' => 'public/'.$request->image->getClientOriginalName()
        ]);

        return $image;
    }
}
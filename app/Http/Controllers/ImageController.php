<?php

namespace App\Http\Controllers;
	
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function getImages()
    {
        $images = File::files(public_path('images/public'));
        $imageNames = [];
        foreach ($images as $image) {
            $imageNames[] = $image->getFilename();
        }
        return $imageNames;
    }
}
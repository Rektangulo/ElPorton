<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Image;

class Menu extends Model
{
    use HasFactory;
	
	protected $fillable=[
		"name",
		"description",
		"price",
		"image_id",
	];
	
	public function image()
	{
		return $this->belongsTo(Image::class);
	}
	
	public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

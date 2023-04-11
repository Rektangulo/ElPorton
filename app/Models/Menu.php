<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class Menu extends Model
{
    use HasFactory;
	
	protected $fillable=[
		"name",
		"description",
		"price",
		"image",
	];
	
	public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

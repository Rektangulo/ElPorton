<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class Tag extends Model
{
    use HasFactory;
	
	protected $fillable=[
		"name",
		"image_id",
	];
	
	public function image()
	{
		return $this->belongsTo(Image::class);
	}
	
	public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}

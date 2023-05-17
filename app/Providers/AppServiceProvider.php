<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
		
		View::composer(['admin.create', 'admin.show'], function ($view) {
			$view->with('images', Image::all());
			$view->with('tags', Tag::all());
			$view->with('categories', Category::all());
		});
    }
}

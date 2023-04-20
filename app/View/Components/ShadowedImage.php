<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShadowedImage extends Component
{
	
	public $image;
    public $text;
    public $height;
    public $shadowOpacity;
	public $fontSize;
	
    /**
     * Create a new component instance.
     */
    public function __construct($image, $text = '', $height = '700px', $shadowOpacity = '0.5', $fontSize = '34px')
    {
        $this->image = $image;
        $this->text = $text;
        $this->height = $height;
        $this->shadowOpacity = $shadowOpacity;
		$this->fontSize = $fontSize;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shadowed-image');
    }
}

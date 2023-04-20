<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class Separator extends Component
{
    public $image;
    public $text;

    public function __construct($image, $text)
    {
        $this->image = $image;
        $this->text = $text;
    }

    public function render()
    {
        return view('components.separator', [
            'image' => $this->image,
            'text' => $this->text,
        ]);
    }
}
<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * @var string
     */
    public $title;

    /**
     * Title show in header partial
     *
     * @var string
     */
    public $headerTitle;

    /**
     * Create a new component instance.
     *
     * @param mixed $title
     * @param mixed|null $headerTitle
     * @return void
     */
    public function __construct($title = '', $headerTitle = null) {
        $this->title = $title;
        $this->headerTitle = $headerTitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render() {
        return view('layouts.app');
    }
}

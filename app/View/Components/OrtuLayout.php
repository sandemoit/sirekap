<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OrtuLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public $title; // Tambahkan properti untuk title  

    public function __construct($title = 'SIREKAP SISWA') // Berikan nilai default  
    {
        $this->title = $title; // Simpan title ke properti  
    }

    public function render(): View
    {
        return view('layouts.ortu', ['title' => $this->title]); // Kirim title ke view  
    }
}

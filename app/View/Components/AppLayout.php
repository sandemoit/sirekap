<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $title; // Tambahkan properti untuk title  

    public function __construct($title = 'SIREKAP SISWA') // Berikan nilai default  
    {
        $this->title = $title; // Simpan title ke properti  
    }

    public function render(): View
    {
        return view('layouts.app', ['title' => $this->title]); // Kirim title ke view  
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Competitions;
use Illuminate\Http\Request;

class WellcomeController extends Controller
{
    public function index()
    {
        $competition = Competitions::with('class:id,name')
            ->select('competition_name', 'date', 'description', 'image')
            ->get();
        return view('welcome', compact('competition'));
    }
}

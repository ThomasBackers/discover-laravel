<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * dedicated to the homepage generation
     */
    public function index()
    {
        return view('index');
    }
}

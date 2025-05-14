<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get 4 random products as featured
        $featuredProducts = Product::inRandomOrder()->limit(4)->get();
        return view('welcome', compact('featuredProducts'));
    }
}

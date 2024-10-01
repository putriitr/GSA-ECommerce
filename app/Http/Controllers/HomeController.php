<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Parameter;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $parameters = Parameter::all();
        $sliders = Slider::all();
        $products = Product::all();


        return view('home', compact('sliders', 'parameters', 'products'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Parameter;
use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $parameters = Parameter::all();
        $sliders = Slider::all();
        $products = Product::all();
        $services = Service::all();

        return view('home', compact('sliders', 'parameters', 'products', 'services'));
    }

    public function shop()
    {
        $products = Product::with('category')->get(); 
        $categories = Category::all();

        return view('member.shop', compact('products', 'categories'));
    }
}

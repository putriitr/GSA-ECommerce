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
/*         $parameters = Parameter::all();
        $sliders = Slider::all();
        $products = Product::all();
        $services = Service::all();
 */
        return view('member.home.home');
    }
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('admin.dashboard.dashboard');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function managerHome()
    {
        return view('managerHome');
    }


    

}

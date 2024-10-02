<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class MemberController extends Controller
{
    public function index()
    {
        // Ambil semua slider dari database
        $sliders = Slider::all();
        // Pastikan menggunakan view yang benar, misalnya member.index
        return view('member.index', compact('sliders'));
    }
}

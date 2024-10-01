<?php

namespace App\Http\Controllers\Admin\Slider;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // $imagePath = $request->file('image')->store('sliders', 'public');
        $image = $request->file('image');

        // Buat nama unik untuk file gambar
       // $imageName = $image->getFilename();
        $imageName=$_FILES['image']['name'];
        $image->move(public_path('storage/img/slider/'), $imageName);
        $imagePath = 'storage/img/slider/' . $imageName;
        //dd($imagePath);
        //$imgname=$request->file('image')->getFilename();
        //$request->file('image')->move('public/storage/img/product',$imgname);

        Slider::create([
            'image' => $imagePath,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('sliders.index')->with('success', 'Slider created successfully.');
    }

    public function show($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.show', compact('slider'));
    }


    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

         // $imagePath = $request->file('image')->store('sliders', 'public');
         $image = $request->file('image');

         // Buat nama unik untuk file gambar
         //$imageName = $image->getFilename();;
         $imageName=$_FILES['image']['name'];
         $imagePath = 'storage/img/slider/' . $imageName;
        // dd($imagePath);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($slider->image==$imagePath ) {
                //\Storage::disk('public')->delete($slider->image);
            }else{
                $image->move(public_path('storage/img/slider/'), $imageName);
            }

            //$imagePath = $request->file('image')->store('sliders', 'public');
            $slider->image = $imagePath;
        }


        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->save();

        return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        // Hapus gambar jika ada
        if ($slider->image) {
            \Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();
        return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
    }
}

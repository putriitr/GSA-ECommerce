<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\BannerHome;
use Illuminate\Http\Request;

class BannerHomeController extends Controller
{
    public function index()
    {
        // Fetch all active banners
        $banners = BannerHome::where('active', 1)->orderBy('order')->paginate(10); // Adjust the number to your preference
        return view('admin.banner.banner-home.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.banner-home.create');
    }

    public function store(Request $request)
    {
        $validRoutes = [
            route('home'),
            route('shop'),
        ];

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048', // Added svg to the allowed types
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|in:' . implode(',', $validRoutes), // Validate against the defined routes
            'order' => 'nullable|integer|unique:t_banner_home,order', // Validasi unik untuk order
            'active' => 'nullable|boolean',
        ]);

        if($request->hasFile('image')){
            // Store the image
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/banner-home'), $filename);

            // Create the banner
            BannerHome::create([
                'image' => 'assets/banner-home/' . $filename,
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
                'order' => $request->order,
                'active' => $request->active ?? true,
            ]);
        }

        return redirect()->route('admin.banner-home.banners.index')->with('success', 'Banner created successfully!');
    }

    public function show($id)
    {
        $banner = BannerHome::findOrFail($id);
        return view('admin.banner.banner-home.show', compact('banner'));
    }


    public function edit($id)
    {
        $banner = BannerHome::findOrFail($id);
        return view('admin.banner.banner-home.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = BannerHome::findOrFail($id);

        $validRoutes = [
            route('home'),
            route('shop'),
            route('category.filter.ajax'),
            route('customer.product.show', ['slug' => 'example']), // Add a placeholder slug for validation
        ];

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048', // Added svg to the allowed types
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|in:' . implode(',', $validRoutes), // Validate against the defined routes
            'order' => 'nullable|integer|unique:t_banner_home,order,' . $banner->id, // Validasi unik untuk order
            'active' => 'nullable|boolean',
        ]);

        $banner = BannerHome::findOrFail($id);

        if($request->hasFile('image')){
            // Delete the old image if needed
            if (file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }

            // Store the new image
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/banner-home'), $filename);
            $banner->image = 'assets/banner-home/' . $filename;
        }

        // Update the rest of the fields
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->link = $request->link;
        $banner->order = $request->order;
        $banner->active = $request->active ?? true;
        $banner->save();

        return redirect()->route('admin.banner-home.banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy($id)
    {
        $banner = BannerHome::findOrFail($id);
        if (file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }
        $banner->delete();
        return redirect()->route('admin.banner-home.banners.index')->with('success', 'Banner deleted successfully!');
    }

}

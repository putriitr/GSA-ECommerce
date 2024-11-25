<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\BannerMicro;
use Illuminate\Http\Request;

class BannerMicroController extends Controller
{
    public function index()
    {
        $banners = BannerMicro::all();
        return view('admin.banner.banner-micro.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.banner-micro.create');
    }

    public function store(Request $request)
    {

        $validRoutes = [
            route('home'),
            route('shop'),
        ];

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|in:' . implode(',', $validRoutes), // Validate against the defined routes
            'active' => 'nullable|boolean',
            'page' => 'required|in:show_product,shop',
        ]);

        if ($request->active) {
            BannerMicro::where('page', $request->page)->update(['active' => false]);
        }

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/micro-banners'), $filename);

            BannerMicro::create([
                'image' => 'assets/micro-banners/' . $filename,
                'link' => $request->link,
                'active' => $request->active ?? true,
                'page' => $request->page,
            ]);
        }

        return redirect()->route('admin.banner-micro.banners.index')->with('success', 'Micro banner created successfully!');
    }

    public function edit($id)
    {
        $banner = BannerMicro::findOrFail($id);
        return view('admin.banner.banner-micro.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {

        $validRoutes = [
            route('home'),
            route('shop'),
            route('category.filter.ajax'),
            route('customer.product.show', ['slug' => 'example']), // Add a placeholder slug for validation
        ];

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|in:' . implode(',', $validRoutes), // Validate against the defined routes
            'active' => 'nullable|boolean',
            'page' => 'required|in:show_product,shop',
        ]);

        $banner = BannerMicro::findOrFail($id);

        if ($request->active && $banner->active === false) {
            // Deactivate any existing active banner for the selected page
            BannerMicro::where('page', $request->page)->update(['active' => false]);
        }

        
        if ($request->hasFile('image')) {
            if (file_exists(public_path($banner->image))) {
                unlink(public_path($banner->image));
            }
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/micro-banners'), $filename);
            $banner->image = 'assets/micro-banners/' . $filename;
        }

        $banner->link = $request->link;
        $banner->active = $request->active ?? true;
        $banner->page = $request->page;
        $banner->save();

        return redirect()->route('admin.banner-micro.banners.index')->with('success', 'Micro banner updated successfully!');
    }

    public function show($id)
{
    $banner = BannerMicro::findOrFail($id);
    return view('admin.banner.banner-micro.show', compact('banner'));
}

    public function destroy($id)
    {
        $banner = BannerMicro::findOrFail($id);
        if (file_exists(public_path($banner->image))) {
            unlink(public_path($banner->image));
        }
        $banner->delete();
        return redirect()->route('admin.banner-micro.banners.index')->with('success', 'Micro banner deleted successfully!');
    }

}

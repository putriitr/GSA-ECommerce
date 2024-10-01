<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
      //  dd(env('APP_URL'));
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required',
            'description' => 'required',
        ]);


        $image = $request->file('image');

        // Buat nama unik untuk file gambar
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('storage/img/product/'.$request->category.'/'), $imageName);
        $imagePath='storage/img/product/'.$request->category.'/'.$imageName;
        //$imgname=$request->file('image')->getFilename();
        //$request->file('image')->move('public/storage/img/product',$imgname);

        Product::create([
            'name' => $request->name,
            'image' =>$imagePath,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
        ]);

        $image = $request->file('image');

        // Buat nama unik untuk file gambar
        $imageName = time().'.'.$image->extension();



        if ($request->hasFile('image')) {
            //Storage::disk('public')->delete($product->image);
               // Pindahkan gambar ke direktori penyimpanan public/images
              $image->move(public_path('storage/img/product/'.$request->category.'/'), $imageName);
           // $imagePath = $request->file('image')->store('img/product/'.$request->category, 'public');
           $imagePath='storage/img/product/'.$request->category.'/'.$imageName;
           $product->image = $imagePath;

        }
        $product->update($request->only(['name', 'category', 'description']));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}

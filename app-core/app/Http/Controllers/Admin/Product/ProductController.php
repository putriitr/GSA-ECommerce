<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVideos;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(5);
        return view('admin.product.index', compact('products'));
    }
    

    public function create()
    {
        $categories = Category::all(); // Mengambil semua kategori
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|max:255|unique:t_product,name', // Name harus unik
        'category_id' => 'required|exists:t_p_category,id',
        'stock' => 'required|numeric|min:0',
        'description' => 'required',
        'specification' => 'required',
        'price' => 'required|numeric|min:0', // Harga produk wajib
        'is_discount' => 'boolean', // Indikator diskon
        'discount_price' => 'nullable|numeric|min:0|lt:price|required_if:is_discount,1', // Harga diskon hanya wajib jika is_discount true
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar wajib
        'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000', // Video opsional
        'is_pre_order' => 'boolean',
        'is_negotiable' => 'boolean',
    ]);

    // Buat slug dari nama produk
    $slug = Str::slug($request->name);

    // Simpan produk baru
    $product = Product::create([
        'name' => $request->name,
        'slug' => $slug,
        'stock' => $request->stock,
        'category_id' => $request->category_id,
        'description' => $request->description,
        'specification' => $request->specification,
        'price' => $request->price, 
        'discount_price' => $request->is_discount ? $request->discount_price : null,  
        'is_pre_order' => $request->is_pre_order ?? false,
        'is_negotiable' => $request->is_negotiable ?? false,
        'status_published' => 'Unpublished', 
    ]);

    // Simpan gambar
    if($request->hasFile('images')){
        foreach ($request->file('images') as $image) {
            // Simpan di folder public/assets/images
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images'), $filename);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'assets/images/' . $filename
            ]);
        }
    }

    // Simpan video jika ada
    if ($request->hasFile('video')) {
        // Simpan di folder public/assets/videos
        $videoName = time() . '_' . $request->file('video')->getClientOriginalName();
        $request->file('video')->move(public_path('assets/videos'), $videoName);

        ProductVideos::create([
            'product_id' => $product->id,
            'video' => 'assets/videos/' . $videoName
        ]);
    }

    return redirect()->route('product.index')->with('success', 'Product created successfully.');
}




     // Show form untuk edit
     public function edit(Product $product)
     {
         $categories = Category::all();
         $product->load('images', 'videos');
         return view('admin.product.edit', compact('product', 'categories'));
     }
 
     // Update produk
     public function update(Request $request, Product $product)
     {
         // Validasi input
         $request->validate([
             'name' => 'required|max:255|unique:t_product,name,' . $product->id, // Name harus unik kecuali produk saat ini
             'category_id' => 'required|exists:t_p_category,id',
             'stock' => 'required|numeric',
             'description' => 'required',
             'specification' => 'required',
             'price' => 'required|numeric|min:0', // Harga produk wajib
             'is_discount' => 'boolean', // Indikator diskon
             'discount_price' => 'nullable|numeric|min:0|lt:price|required_if:is_discount,1', // Harga diskon hanya wajib jika is_discount true
             'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar opsional
             'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000', // Video opsional
             'is_pre_order' => 'boolean',
             'is_negotiable' => 'boolean',
             'status_published' => 'required|in:Published,Unpublished',
         ]);
     
         // Buat slug dari nama produk
         $slug = Str::slug($request->name);

         $isDiscount = $request->discount_price ? 1 : ($request->has('is_discount') ? 1 : 0);

     
         // Update produk
         $product->update([
             'name' => $request->name,
             'slug' => $slug,
             'stock' => $request->stock,
             'category_id' => $request->category_id,
             'description' => $request->description,
             'specification' => $request->specification,
             'price' => $request->price,
             'discount_price' => $request->is_discount ? $request->discount_price : null, // Update harga diskon jika is_discount aktif
             'is_pre_order' => $request->is_pre_order ?? false,
             'is_negotiable' => $request->is_negotiable ?? false,
             'status_published' => $request->status_published, 
         ]);
     
         // Simpan gambar baru jika ada
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $imageFile) {
                 $filename = time() . '_' . $imageFile->getClientOriginalName();
                 $imageFile->move(public_path('assets/images'), $filename);
     
                 ProductImage::create([
                     'product_id' => $product->id,
                     'image' => 'assets/images/' . $filename
                 ]);
             }
         }
     
         // Update video jika ada
         if ($request->hasFile('video')) {
             // Hapus video lama dari folder public jika ada
             if ($product->videos->isNotEmpty()) {
                 foreach ($product->videos as $video) {
                     $videoPath = public_path($video->video);
                     if (file_exists($videoPath)) {
                         unlink($videoPath); // Hapus file video dari folder
                     }
                     $video->delete(); // Hapus record video dari database
                 }
             }
     
             // Simpan video baru
             $videoName = time() . '_' . $request->file('video')->getClientOriginalName();
             $request->file('video')->move(public_path('assets/videos'), $videoName);
     
             ProductVideos::create([
                 'product_id' => $product->id,
                 'video' => 'assets/videos/' . $videoName
             ]);
         }
     
         return redirect()->route('product.index')
                         ->with('success', 'Product updated successfully.');
     }
     

 
     // Hapus produk
     public function destroy(Product $product)
{
    // Hapus gambar terkait dari folder public
    foreach ($product->images as $image) {
        $imagePath = public_path($image->image);
        if (file_exists($imagePath)) {
            unlink($imagePath); // Hapus file gambar dari folder
        }
        $image->delete(); // Hapus record gambar dari database
    }

    // Hapus video terkait dari folder public jika ada
    if ($product->videos->isNotEmpty()) {
        foreach ($product->videos as $video) {
            $videoPath = public_path($video->video);
            if (file_exists($videoPath)) {
                unlink($videoPath); // Hapus file video dari folder
            }
            $video->delete(); // Hapus record video dari database
        }
    }

    // Hapus produk itu sendiri
    $product->delete();

    return redirect()->route('product.index')
                     ->with('success', 'Product deleted successfully.');
}



    public function show(Product $product)
    {
        // Load gambar dan video terkait untuk ditampilkan
        $product->load('images', 'videos');
        
        return view('admin.product.show', compact('product'));
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $imagePath = public_path($image->image);
    
        if (file_exists($imagePath)) {
            unlink($imagePath); // Hapus file gambar dari folder
        }
    
        $image->delete(); // Hapus record gambar dari database
    
        return response()->json(['success' => 'Image deleted successfully.']);
    }
    


    public function deleteVideo($id)
    {
        $video = ProductVideos::findOrFail($id);
        $videoPath = public_path($video->video);
    
        if (file_exists($videoPath)) {
            unlink($videoPath); // Hapus file video dari folder
        }
    
        $video->delete(); // Hapus record video dari database
    
        return response()->json(['success' => 'Video deleted successfully.'], 200);
    }

    public function uploadImages(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $images = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imageFile) {
            $filename = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('assets/images'), $filename);

            $image = ProductImage::create([
                'product_id' => $product->id,
                'image' => 'assets/images/' . $filename
            ]);
            $images[] = [
                'id' => $image->id,
                'url' => asset($image->image),
            ];
        }
    }

    return response()->json(['images' => $images], 200);
}

public function updateStatus(Request $request)
{
    // Validasi input
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'status_published' => 'required|in:Published,Unpublished'
    ]);

    // Temukan produk dan perbarui statusnya
    $product = Product::find($request->product_id);
    $product->status_published = $request->status_published;
    $product->save();

    return response()->json(['success' => true]);
}




}

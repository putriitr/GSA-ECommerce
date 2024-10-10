<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.product.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.product.categories.create');
    }

    public function store(Request $request)
    {
        // Validasi name
        $request->validate([
            'name' => 'required|max:255|unique:t_p_category,name', // Validasi name harus unik
        ]);
    
        // Buat slug dari name
        $slug = Str::slug($request->name);
    
        // Simpan data kategori dengan slug yang dihasilkan
        Category::create([
            'name' => $request->name,
            'slug' => $slug
        ]);
    
        return redirect()->route('product.categories.index')
                        ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.product.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    // Validasi name
    $request->validate([
        'name' => 'required|max:255|unique:t_p_category,name', // Validasi name harus unik
    ]);

    // Buat slug dari name
    $slug = Str::slug($request->name);

    // Update data kategori dengan slug yang dihasilkan
    $category->update([
        'name' => $request->name,
        'slug' => $slug
    ]);

    return redirect()->route('product.categories.index')
                    ->with('success', 'Category updated successfully.');
}

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('product.categories.index')
                        ->with('success', 'Category deleted successfully.');
    }

}

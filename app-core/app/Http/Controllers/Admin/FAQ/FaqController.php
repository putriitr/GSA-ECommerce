<?php

namespace App\Http\Controllers\Admin\FAQ;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
        ]);

        // Check if a FAQ already exists
        if (Faq::count() >= 1) {
            return redirect()->route('admin.faq.index')->with('error', 'Only one FAQ entry is allowed.');
        }

        // Create the new FAQ if none exists
        Faq::create($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ created successfully.');
    }


    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ deleted successfully.');
    }

    public function show($id)
    {
        // Retrieve the FAQ by ID
        $faq = Faq::findOrFail($id);

        // Return a view with the FAQ data
        return view('admin.faq.show', compact('faq'));
    }
}

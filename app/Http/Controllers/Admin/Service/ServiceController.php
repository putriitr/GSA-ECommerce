<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // Tampilkan daftar service
    public function index()
    {
        $services = Service::all();
        return view('admin.service.index', compact('services'));
    }

    // Form untuk menambah service baru
    public function create()
    {
        return view('admin.service.create');
    }

    // Simpan service baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'icon' => 'required|string', // Validasi untuk ikon
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')
            ->with('success', 'Service berhasil ditambahkan.');
    }


    // Form untuk edit service
    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    // Update service di database
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')
            ->with('success', 'Service berhasil diperbarui.');
    }

    // Hapus service dari database
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')
            ->with('success', 'Service berhasil dihapus.');
    }

    public function show(Service $service)
    {
        return view('admin.service.show', compact('service'));
    }
}

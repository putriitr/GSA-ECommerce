<?php

namespace App\Http\Controllers\Admin\MasterData\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingService;
use Illuminate\Http\Request;

class ShippingServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingServices = ShippingService::all();
        return view('admin.masterdata.shipping.index', compact('shippingServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.masterdata.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ShippingService::create($request->all());

        return redirect()->route('masterdata.shipping.index')->with('success', 'Shipping Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $shippingService = ShippingService::find($id);
        return view('admin.masterdata.shipping.edit', compact('shippingService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $shippingService = ShippingService::find($id);
        $shippingService->update($request->all());

        return redirect()->route('masterdata.shipping.index')->with('success', 'Shipping Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $shippingService = ShippingService::find($id);
        $shippingService->delete();

        return redirect()->route('masterdata.shipping.index')->with('success', 'Shipping Service deleted successfully.');
    }
}

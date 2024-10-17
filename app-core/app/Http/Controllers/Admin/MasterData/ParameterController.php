<?php

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function index()
    {
        $parameters = Parameter::all(); // Get all parameters
        return view('admin.masterdata.parameter.index', compact('parameters'));
    }

    public function create()
    {
        return view('admin.masterdata.parameter.create'); // Return the create view
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'logo_tambahan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',        
            'nomor_wa' => 'nullable|string',
            'email' => 'nullable|email',
            'slogan_welcome' => 'nullable|string',
            'alamat' => 'nullable|string',
            'nama_ecommerce' => 'nullable|string',
            'email_pengaduan_kementrian' => 'nullable|email',
            'website_kementerian' => 'nullable|url',
        ]);

        // Check if there is already a parameter record
        if (Parameter::count() > 0) {
            return redirect()->route('masterdata.parameters.index')->with('error', 'Only one parameter entry is allowed.');
        }

        $parameter = new Parameter();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $filename = time() . '_logo.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('assets/images'), $filename);
            $parameter->logo = 'assets/images/' . $filename;
        }

        // Handle additional logo upload
        if ($request->hasFile('logo_tambahan')) {
            $filename = time() . '_logo_tambahan.' . $request->file('logo_tambahan')->getClientOriginalExtension();
            $request->file('logo_tambahan')->move(public_path('assets/images'), $filename);
            $parameter->logo_tambahan = 'assets/images/' . $filename;
        }

        // Store other parameter fields
        $parameter->nomor_wa = $request->nomor_wa;
        $parameter->email = $request->email;
        $parameter->slogan_welcome = $request->slogan_welcome;
        $parameter->alamat = $request->alamat;
        $parameter->nama_ecommerce = $request->nama_ecommerce;
        $parameter->email_pengaduan_kementrian = $request->email_pengaduan_kementrian;
        $parameter->website_kementerian = $request->website_kementerian;

        $parameter->save();

        return redirect()->route('masterdata.parameters.index')->with('success', 'Parameter created successfully.');
    }

    public function edit($id)
    {
        $parameter = Parameter::findOrFail($id);
        return view('admin.masterdata.parameter.edit', compact('parameter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'logo_tambahan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'nomor_wa' => 'nullable|string',
            'email' => 'nullable|email',
            'slogan_welcome' => 'nullable|string',
            'alamat' => 'nullable|string',
            'nama_ecommerce' => 'nullable|string',
            'email_pengaduan_kementrian' => 'nullable|email',
            'website_kementerian' => 'nullable',
        ]);

        $parameter = Parameter::findOrFail($id);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($parameter->logo) {
                unlink(public_path($parameter->logo));
            }
            $filename = time() . '_logo.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move(public_path('assets/images'), $filename);
            $parameter->logo = 'assets/images/' . $filename;
        }

        // Handle additional logo upload
        if ($request->hasFile('logo_tambahan')) {
            // Delete old additional logo if exists
            if ($parameter->logo_tambahan) {
                unlink(public_path($parameter->logo_tambahan));
            }
            $filename = time() . '_logo_tambahan.' . $request->file('logo_tambahan')->getClientOriginalExtension();
            $request->file('logo_tambahan')->move(public_path('assets/images'), $filename);
            $parameter->logo_tambahan = 'assets/images/' . $filename;
        }

        // Update other parameters
        $parameter->nomor_wa = $request->nomor_wa;
        $parameter->email = $request->email;
        $parameter->slogan_welcome = $request->slogan_welcome;
        $parameter->alamat = $request->alamat;
        $parameter->nama_ecommerce = $request->nama_ecommerce;
        $parameter->email_pengaduan_kementrian = $request->email_pengaduan_kementrian;
        $parameter->website_kementerian = $request->website_kementerian;

        $parameter->save();

        return redirect()->route('masterdata.parameters.index')->with('success', 'Parameter updated successfully.');
    }

    public function destroy($id)
    {
        $parameter = Parameter::findOrFail($id);

        // Optionally delete the logo files if they exist
        if ($parameter->logo) {
            unlink(public_path($parameter->logo));
        }
        if ($parameter->logo_tambahan) {
            unlink(public_path($parameter->logo_tambahan));
        }

        $parameter->delete();

        return redirect()->route('masterdata.parameters.index')->with('success', 'Parameter deleted successfully.');
    }

    

}

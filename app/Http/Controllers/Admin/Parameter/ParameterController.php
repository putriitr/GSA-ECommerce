<?php

namespace App\Http\Controllers\Admin\Parameter;

use App\Http\Controllers\Controller;
use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function index()
    {
        $parameters = Parameter::all();
        return view('admin.parameter.index', compact('parameters'));
    }

    public function create()
    {
        return view('admin.parameter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'tagline' => 'required|string|max:255',
        ]);

        $parameter = Parameter::first();
        if ($parameter) {
            // Update existing parameter
            $parameter->update($request->all());
        } else {
            // Create new parameter if none exists
            Parameter::create($request->all());
        }
        
        return redirect()->route('parameters.index')->with('success', 'Parameter created successfully.');
    }

    public function edit(Parameter $parameter)
    {
        return view('admin.parameter.edit', compact('parameter'));
    }

    public function update(Request $request, Parameter $parameter)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'tagline' => 'required|string|max:255',
        ]);

        $parameter->update($request->all());
        return redirect()->route('parameters.index')->with('success', 'Parameter updated successfully.');
    }

    public function destroy(Parameter $parameter)
    {
        $parameter->delete();
        return redirect()->route('parameters.index')->with('success', 'Parameter deleted successfully.');
    }
}

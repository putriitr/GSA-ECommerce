<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');
    
        // Retrieve users with pagination and optional search
        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('phone', 'like', "%{$search}%");
            })
            ->paginate(10); // 10 users per page
    
        // Pass the search query back to the view to preserve it in the input field
        return view('admin.users.index', compact('users', 'search'));
    }
    
    

    public function edit($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        // Update the user information
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'phone', 'type']));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // Delete the user
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function updatePassword(Request $request, $id)
    {
        // Validate the new password
        $request->validate([
            'password' => 'required|string|min:8|confirmed', // Password and password confirmation validation
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the password
        $user->update([
            'password' => Hash::make($request->input('password')), // Hash the new password
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Password updated successfully.');
    }
}

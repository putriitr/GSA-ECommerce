<?php

namespace App\Http\Controllers\Customer\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('customer.settings.account.profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
    
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:15',
            'profile_photo' => 'nullable|image|max:2048',
        ]);
    
        // Update user profile information using DB::table
        DB::table('t_users')
            ->where('id', $user->id)
            ->update([
                'full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);
    
        // Handle profile photo upload separately
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '-' . $file->getClientOriginalName();
            $destinationPath = public_path('profile_photos'); // Save in 'public/profile_photos'
    
            // Create the directory if it doesn't exist
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
    
            // Move the file to the public path
            $file->move($destinationPath, $filename);
    
            // Save the profile photo path in the database
            DB::table('t_users')
                ->where('id', $user->id)
                ->update([
                    'profile_photo' => 'profile_photos/' . $filename, // Store relative path
                ]);
        }
    
        return back()->with('success', 'Profil berhasil diperbarui.');
    }


    
public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed|min:8',
    ]);

    $user = auth()->user();

    // Check if current password matches
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Kata sandi lama salah.']);
    }

    // Hash the new password
    $hashedPassword = Hash::make($request->new_password);

    // Update the password directly in the database using DB::table
    DB::table('t_users')
        ->where('id', $user->id)
        ->update(['password' => $hashedPassword]);

    return back()->with('success', 'Kata sandi berhasil diperbarui.');
}

public function createPassword(Request $request)
{
    // Validate the request data
    $request->validate([
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Ensure the user doesn't already have a password
    if ($user->password) {
        return redirect()->back()->with('error', 'You already have a password.');
    }

    // Update the password using the DB facade
    DB::table('t_users')
        ->where('id', $user->id)
        ->update(['password' => Hash::make($request->new_password)]);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Password created successfully. You can now log in using your email and password.');
}
}
